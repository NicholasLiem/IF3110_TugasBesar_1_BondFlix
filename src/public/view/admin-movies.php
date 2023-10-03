<?php
$pageTitle = 'Movie Dashboard';
$stylesheet = '/public/css/admin-movies.css';
$script = 'admin.js';
include BASE_PATH . "/public/templates/header.php";
$adminSidebarTemplate = BASE_PATH . "/public/templates/admin-sidebar.php";
$username = $_SESSION['username'];
?>

<link rel="stylesheet" href="/public/css/admin-page.css">
<link rel="stylesheet" href="/public/css/admin-table.css">
<link rel="stylesheet" href="/public/css/admin-movies.css">
<script src="/public/js/admin-movies.js" defer></script>
<?php include $adminSidebarTemplate ?>

<body>
    <div class="content">
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search...">
            <button id="search-button" class="search-bar-button">Search</button>
            <!--        <button id="sort-button" class="search-bar-button">-->
            <!--            <span class="sort-text">Sort</span>-->
            <!--            <span class="arrow-down"></span>-->
            <!--        </button>-->
            <!--        <div class="dropdown filter-dropdown search-bar-button">-->
            <!--            <button id="filter-button" class="filter-button">-->
            <!--                <span class="filter-text">Filter</span>-->
            <!--                <span class="arrow-down"></span>-->
            <!--            </button>-->
            <!--            <div class="dropdown-content filter-dropdown-content">-->
            <!--                <a href="#">Option 1</a>-->
            <!--                <a href="#">Option 2</a>-->
            <!--                <a href="#">Option 3</a>-->
            <!--            </div>-->
            <!--        </div>-->
            <button id="refresh-button" class="search-bar-button">Refresh</button>
        </div>
        <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Release Date</th>
                <th>Content File Path</th>
                <th>Thumbnail File Path</th>
                <th>Action</th>
            </tr>
        </table>
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit User</h2>
                <table class="edit-user-modal">
                    <tr>
                        <td><label for="editTitle">Title</label></td>
                        <td><input type="text" id="editTitle" name="title" required></td>
                    </tr>
                    <tr>
                        <td><label for="editDescription">Description</label></td>
                        <td><input type="text" id="editDescription" name="description" required></td>
                    </tr>
                    <tr>
                        <td><label for="editReleaseDate">Release Date</label></td>
                        <td><input type="date" id="editReleaseDate" name="releaseDate" required></td>
                    </tr>
                    <tr>
                        <td><label for="editContentFilePath">Content File Path</label></td>
                        <td><input type="text" id="editContentFilePath" name="conentFilePath" required></td>
                    </tr>
                    <tr>
                        <td><label for="editThumbnailPath">Thumbnail File Path</label></td>
                        <td><input type="text" id="editThumbnailPath">Thumbnail Path</td>
                    </tr>
                </table>
                <button type="submit" class="submit-edit" id="saveEditButton">Save</button>
            </div>
        </div>
    </div>
</body>
