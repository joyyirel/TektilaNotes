function myMenuFunction() {
	var i = document.getElementById("navMenu");

	if(i.className === "nav-menu") {
		i.className += " responsive";
	} else {
		i.className = "nav-menu";
	}
}
var a = document.getElementById("loginBtn");
var b = document.getElementById("registerBtn");
var log = document.getElementById("login");
var reg = document.getElementById("register");
var fp = document.getElementById("forgot");

function login() {
	log.style.left = "5px";
	reg.style.right = "-520px";
	a.className += " white-btn";
	b.className = "btn";
	log.style.opacity = 1;
	reg.style.opacity = 0;
	document.title = "Techtilanotes | Login";
}

function register() {
	log.style.left = "-510px";
	reg.style.right = "5px";
	fp.style.right = "520px"
	a.className = "btn";
	b.className += " white-btn";
	log.style.opacity = 0;
	reg.style.opacity = 1;
	document.title = "Techtilanotes | Register";
}

function forgot() {
	log.style.left = "510px";
	fp.style.right = "5px";
	log.style.opacity = 0;
	fp.style.opacity = 1;
	document.title = "Techtilanotes | Forgot Password";
}

/* NOTES */
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