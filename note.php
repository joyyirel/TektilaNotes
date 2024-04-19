<?php
include 'config.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT firstName FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['firstName'];
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Techtilanotes</title>
    <link rel="stylesheet" href="note.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="window.js"></script>
    <script src="https://kit.fontawesome.com/535a9c8dda.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="" class="logo">
                    <img src="./assets/haerin.jpg" alt="">
                    <span class="nav-item"><?php echo $firstName; ?></span>
                </a>
            </li>
            <li class="menu">
                <a href="">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-item">home</span>
                </a>
            </li>
            <li class="menu">
                <a href="">
                    <i class="fa-solid fa-list"></i>
                    <span class="nav-item">list</span>
                </a>
            </li>
            <li class="menu">
                <a href="">
                    <i class="fa-solid fa-gear"></i>
                    <span class="nav-item">Settings</span>
                </a>
            </li>
            <li class="menu">
                <a href="logout.php" class="logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-item">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
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
            <div class="chicken">
                <div class="comb1"></div>
                <div class="comb2"></div>
                <div class="eye"></div>
                <div class="beak"></div>
                <div class="wattle"></div>
            </div>
            <p>Add new note</p>
        </li>
    </div>

    <script src="script.js"></script>

    <script>
        function showNotes() {
            if (!notes) return;
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
    </script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>