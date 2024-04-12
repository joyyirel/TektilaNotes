


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">  
    <title>TiktilaNotes</title>
    <link rel="stylesheet" href="note.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>

<div class="popup-box">
    <div class="popup">
        <div class="content">
            <header>
                <p></p>
                <i class="uil uil-times"></i>
            </header>
            <form action="#">
                <div class="row title">
                    <label>Title</label>
                    <input type="text" spellcheck="false">
                </div>
                <div class="row description">
                    <label>Description</label>
                    <textarea spellcheck="false"></textarea>
                </div>
                <button></button>
            </form>
        </div>
    </div>
</div>
<div class="wrapper">
    <li class="add-box">
        <div class="icon"><i class="uil uil-plus"></i></div>
        <p>Add new note</p>
    </li>
</div>

<script>
    const addBox = document.querySelector(".add-box"),
    popupBox = document.querySelector(".popup-box"),
    popupTitle = popupBox.querySelector("header p"),
    closeIcon = popupBox.querySelector("header i"),
    titleTag = popupBox.querySelector("input"),
    descTag = popupBox.querySelector("textarea"),
    addBtn = popupBox.querySelector("button");

    const months = ["January", "February", "March", "April", "May", "June", "July",
                  "August", "September", "October", "November", "December"];
    const notes = JSON.parse(localStorage.getItem("notes") || "[]");
    let isUpdate = false, updateId;

    addBox.addEventListener("click", () => {
        popupTitle.innerText = "Add a new Note";
        addBtn.innerText = "Add Note";
        popupBox.classList.add("show");
        document.querySelector("body").style.overflow = "hidden";
        if(window.innerWidth > 660) titleTag.focus();
    });

    closeIcon.addEventListener("click", () => {
        isUpdate = false;
        titleTag.value = descTag.value = "";
        popupBox.classList.remove("show");
        document.querySelector("body").style.overflow = "auto";
    });

    function showNotes() {
        if(!notes) return;
        document.querySelectorAll(".note").forEach(li => li.remove());
        notes.forEach((note, id) => {
            let filterDesc = note.description.replaceAll("\n", '<br/>');
            let liTag = `<li class="note">
                            <div class="details">
                                <p>${note.title}</p>
                                <span>${filterDesc}</span>
                            </div>
                            <div class="bottom-content">
                                <span>${note.date}</span>
                                <div class="settings">
                                    <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                                    <ul class="menu">
                                        <li onclick="updateNote(${id}, '${note.title}', '${filterDesc}')">
                                            <i class="uil uil-pen"></i>
                                            Edit
                                        </li>
                                        <li onclick="deleteNote(${id})">
                                            <i class="uil uil-trash"></i>
                                            Delete
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>`;
            addBox.insertAdjacentHTML("afterend", liTag);
        });
    }
    showNotes();

    function showMenu(elem) {
        elem.parentElement.classList.add("show");
        document.addEventListener("click", e => {
            if(e.target.tagName != "I" || e.target != elem) {
                elem.parentElement.classList.remove("show");
            }
        });
    }

    function deleteNote(noteId) {
        let confirmDel = confirm("Are you sure you want to delete this note?");
        if(!confirmDel) return;
        notes.splice(noteId, 1);
        localStorage.setItem("notes", JSON.stringify(notes));
        showNotes();
    }

    function updateNote(noteId, title, filterDesc) {
        let description = filterDesc.replaceAll('<br/>', '\r\n');
        updateId = noteId;
        isUpdate = true;
        addBox.click();
        titleTag.value = title;
        descTag.value = description;
        popupTitle.innerText = "Update a Note";
        addBtn.innerText = "Update Note";
    }

    addBtn.addEventListener("click", e => {
        e.preventDefault();
        let title = titleTag.value.trim(),
        description = descTag.value.trim();

        if(title || description) {
            let currentDate = new Date(),
            month = months[currentDate.getMonth()],
            day = currentDate.getDate(),
            year = currentDate.getFullYear();

            let noteInfo = {title, description, date: `${month} ${day}, ${year}`}
            if(!isUpdate) {
                notes.push(noteInfo);
            } else {
                isUpdate = false;
                notes[updateId] = noteInfo;
            }
            localStorage.setItem("notes", JSON.stringify(notes));
            showNotes();
            closeIcon.click();
        }
    });

</script>
<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>
