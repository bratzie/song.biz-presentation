<?php
if(isset($_GET["logout"]) && $_GET["logout"]=="1") {
    setcookie("user", "", time()+86400);
    $currentuser = "";
}
else if(isset($_GET["user"]) && isset($_GET["password"])) {
    $string = file_get_contents("db/users.json");
    $json_a = json_decode($string,true);

    $flag = false;

    foreach($json_a["users"] as $user) {
        if($_GET["user"] == $user["username"] && $_GET["password"] == $user["password"]) {
            //echo $user["username"].":".$user["password"]."<br>";
            setcookie("user", $user["username"], time()+86400);
            $currentuser = $user["username"];
            $flag = true;
        }
    }

    if(!$flag) {
        $currentuser = "";
    }
}
else {
    $currentuser = $_COOKIE["user"];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="resources/newnote.png">
    <title>song.biz</title>

    <!-- CSS -->
    <link rel="stylesheet" href="resources/style.css">
</head>
<!-- MAIN VIEW -->
<body>
    <table id="page">
        <tbody>
            <tr>
                <!-- TOP LEFT -->
                <td id="a1">
                    <button id="searchBtn">SEARCH</button><br>
                    <button id="browseBtn" class="inactive">BROWSE</button><br><br>
                    <span class="semibold lightred" id="user"></span><br>
                    <a class="semilight darkred" id="user_thing">LOGOUT</a>
                    <hr>
                </td>
                <!-- TOP MIDDLE -->
                <td id="a2">
                    <div id="logo" style="text-align: center; padding: 8px;"><img src="./resources/songbiz.png" width="500px"></div>
                    <div id="searchFieldArea" class="search">
                        <input id="searchField" type="text">
                    </div>
                    <div id="selectSearchArea" class="search">
                        <form id="searchtype">
                            <input type="radio" name="type" id="songs" value="songs" checked><label for="songs">SONGS</label> | 
                            <input type="radio" name="type" id="users" value="users"><label for="users">USERS</label> | 
                            <input type="radio" name="type" id="collections" value="collections"><label for="collections">COLLECTIONS</label>
                        </form>
                    </div>
                    <div id="browseTop" class="browse" style="display:none">
                        <h2>Browse</h2>
                        <h4>Browse through a selection of our most popular songs</h4>
                    </div>
                    <hr>
                </td>
                <!-- TOP RIGHT -->
                <td id="a3">
                    <span id="curcol" class="semibold lightred">Current collection</span><br>
                    <span id="current_collection" class="semilight darkred">AWESOME SONGS OF LOVE</span>
                    <hr>
                </td>
            </tr>
            <tr>
                <!-- MIDDLE LEFT -->
                <td id="b1">
                    <div id="usercollections"></div>
                </td>
                <!-- MIDDLE MIDDLE -->
                <td id="b2">
                    <!--Search-->
                    <div id="searchresults" class="search">
                    </div>
                    <!--Overlay-->
                    <div id="overlay" style="display:none">
                        <div id="addSongForm">
                            <h4>ADD A SONG</h4>
                            <input id="songTitle" type="text" name="songTitle" placeholder="Title"><br>
                            <textarea id="songLyrics" placeholder="Lyrics"></textarea><br>
                            <!-- <input id="songLyrics" type="text" name="songLyrics" placeholder="Lyrics"><br> -->
                            <input id="songMelody" type="text" name="songMelody" placeholder="Melody"><br>
                            <input id="songComposer" type="text" name="songComposer" placeholder="Composer"><br>
                            <input id="songType" type="text" name="songTitle" placeholder="Type"><br>
                            <button id="submitSongBtn">Submit</button>
                            <button id="returnBtn">Return</button>
                        </div>
                    </div>
                    <!--Browse-->
                    <div id="browse" class="browse" style="display:none;" class="row">
                       <h2>Student</h2>
                       <div id="browseStudent">

                       </div>
                       <h2>Party</h2>
                       <div id="browseParty">

                       </div>
                       <h2>National Anthem</h2>
                       <div id="browseNa">

                       </div>
                   </div>
               </td>
               <!-- MIDDLE RIGHT -->
               <td id="b3">
                <div id="collectionsongs"></div>
            </td>
        </tr>
        <tr>
            <!-- BOTTOM LEFT -->
            <td id="c1">
                <hr>
                <button id="addBtn">+</button>
                <input id="collectionName" type="text" name="collName" placeholder="Name"><br>
                <input id="collectionDescription" type="text" name="collDesc" placeholder="Description">
            </td>
            <!-- BOTTOM MIDDLE -->
            <td id="c2">
                <div id="c2Add">
                    <button id="addSongBtn">+</button>
                </div>
            </td>
            <!-- BOTTOM RIGHT -->
            <td id="c3">
                <hr>
                <div id="trash"></div>
            </td>
        </tr>
    </tbody>
</table>

<script> var current_user = "<?php echo $currentuser; ?>";</script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="scripts/model.js"></script>
<script src="scripts/controllers.js"></script>
<script src="scripts/views.js"></script>
</body>
</html>