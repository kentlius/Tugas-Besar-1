<?php
    require("connect.php");
    session_start();
    require("template/navbar.php");

    $genres = $conn->query("SELECT DISTINCT GENRE FROM song")->fetchAll(PDO::FETCH_ASSOC);
    $jumlahDataPerHalaman = 10;

    
    $jumlahData = $conn->query("SELECT * FROM song")->rowCount();
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif-1);
    
    $sort = "JUDUL ASC";
    $filter = "";
    $searchkey = "";
    $searchselect = "JUDUL";
    $search = "";

    $result = $conn->query("SELECT * FROM song WHERE LOWER($searchselect) LIKE '%$searchkey%' AND LOWER(GENRE) LIKE '%$filter%' ORDER BY $sort LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(!empty($_GET)){
                if(isset($_GET["search"])){
                    $searchkey = $_GET["search"];
                }
                if(isset($_GET["searchselect"])){
                    if($_GET["searchselect"] == "TANGGAL_TERBIT"){
                        $search = "TANGGAL TERBIT";
                        $searchselect = "date_part('year', tanggal_terbit) = $searchkey";
                    }elseif($_GET["searchselect"] == "JUDUL"){
                        $search = "JUDUL";
                        $searchselect = "LOWER(JUDUL) LIKE '%$searchkey%'";
                    }elseif($_GET["searchselect"] == "PENYANYI"){
                        $search = "PENYANYI";
                        $searchselect = "LOWER(PENYANYI) LIKE '%$searchkey%'";
                    }
                }
                if(isset($_GET["filter"])){
                    $filter = strtolower($_GET["filter"]);
                }
                if(isset($_GET["sort"])){
                    $sort = $_GET["sort"];
                }
                if(isset($_GET["reset"])){
                    header("Location: search.php");
                }
            $jumlahData = $conn->query("SELECT * FROM song WHERE LOWER(GENRE) LIKE '%$filter%' AND $searchselect")->rowCount();
            $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
            $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
            $awalData = ($jumlahDataPerHalaman * ($halamanAktif-1));
            $result = $conn->query("SELECT * FROM song WHERE $searchselect AND LOWER(GENRE) LIKE '%$filter%' ORDER BY $sort LIMIT $jumlahDataPerHalaman OFFSET $awalData")->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main">
            <h1>Search</h1>
            <div class='sort-filter'>
                <form method="get" id="search-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="search">
                        <input class="search-bar" type="text" name="search" placeholder="What do you want to search?" value="<?php echo $searchkey; ?>">
                        <select class="searchselect" name="searchselect">
                            <option value="JUDUL" <?php if($search == "JUDUL") {echo 'selected';} ?>>Judul</option>
                            <option value="PENYANYI" <?php if($search == "PENYANYI") {echo 'selected';} ?>>Penyanyi</option>
                            <option value="TANGGAL_TERBIT" <?php if($search == "TANGGAL_TERBIT") {echo 'selected';} ?>>Tahun</option>
                        </select>
                    </div>
                    <h2>Sort and filter by:</h2>
                    <div class='sort'>
                        <label for="sort">Sort by:</label>
                        <select name="sort" id="sort">
                            <option value="JUDUL ASC" <?php if($sort == "JUDUL ASC") {echo 'selected';} ?>>Title (A-Z)</option>
                            <option value="JUDUL DESC" <?php if($sort == "JUDUL DESC") {echo 'selected';} ?>>Title (Z-A)</option>
                            <option value="TANGGAL_TERBIT ASC" <?php if($sort == "TANGGAL_TERBIT ASC") {echo 'selected';} ?>>Release Year (Ascending)</option>
                            <option value="TANGGAL_TERBIT DESC" <?php if($sort == "TANGGAL_TERBIT DESC") {echo 'selected';} ?> >Release Year (Descending)</option>
                        </select>
                    </div>
                    <div class='filter'>
                        <label for="filter">Filter by:</label>
                        <select name="filter" id="filter">
                            <option value=''  <?php if(!$filter) {echo 'selected';} ?>>All</option>
                            <?php foreach($genres as $genre): ?>
                                <?php if($genre["genre"] == $filter): ?>
                                    <option value="<?php echo $genre["genre"]; ?>" selected><?php echo $genre["genre"]; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $genre["genre"]; ?>"><?php echo $genre["genre"]; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="submitBtn" value="OK" hidden>
                        <button class='submitbutton' type="submit" name="submitBtn" value="OK">Submit</button>
                    </input>
                    <input type="submit" name="reset" value="OK" hidden>
                        <button class='submitbutton' type="submit" name="reset" value="OK">Reset</button>
                    </input>
                    <div class='page'>
                            <label for="page">Page:</label>
                            <select name="page" id="page" onchange="submitHandler()">
                                <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                    <?php if($i == $halamanAktif): ?>
                                        <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </select>
                    </div>
                </form>
            </div>
            <h1>Result</h1>
            <div class="song-container">
                <?php foreach ($result as $song) : ?>
                    <?php 
                        if($song["genre"] != NULL){
                            $genre = $song["genre"];
                        } else {
                            $genre = "Unknown";
                        }
                        if($song['album_id'] != NULL){
                            $album = $conn->query("SELECT * FROM album WHERE album_id = '$song[album_id]'")->fetch(PDO::FETCH_ASSOC);
                            $album_name = $album['judul'];
                        }else{
                            $album_name = 'Tidak ada album';
                        }
                    ?>
                    <div class='song'>
                        <a href="detailLagu.php?song_id=<?php echo $song['song_id']; ?>">
                            <div class='song-img'>
                                <img src='<?php echo $song['image_path']; ?>' alt="song image">
                            </div>
                            <div class='song-info'>
                                <h2><?php echo $song['judul']; ?></h2>
                                <p><?php echo substr($song['tanggal_terbit'], 0, 4); ?></p>
                                <p><?php echo $song['penyanyi']; ?></p>
                                <p><?php echo $album['judul'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
<script>
    const submitHandler = () => {
        console.log('submit');
        document.getElementById('search-form').submit();
    };
</script>
</html>