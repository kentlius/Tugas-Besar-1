<?php
    require("connect.php");
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

    $result = $conn->query("SELECT * FROM song WHERE LOWER(JUDUL) LIKE '%$searchkey%' AND LOWER(GENRE) LIKE '%$filter%' ORDER BY $sort LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(!empty($_GET)){
            foreach($_GET as $key => $value){
                if($key == "sort"){
                    $sort = $value;
                }
                elseif($key == "filter"){
                    $filter = strtolower($value);
                }
                elseif($key == "reset"){
                    $sort = "JUDUL ASC";
                    $filter = "";
                    $halamanAktif = 1;
                }elseif($key == "search"){
                    $searchkey = strtolower($value);
                }
            }
            $jumlahData = $conn->query("SELECT * FROM song WHERE LOWER(GENRE) LIKE '%$filter%'")->rowCount();
            $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
            $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
            $awalData = ($jumlahDataPerHalaman * ($halamanAktif-1));
            $result = $conn->query("SELECT * FROM song WHERE LOWER(JUDUL) LIKE '%$searchkey%' AND LOWER(GENRE) LIKE '%$filter%' ORDER BY $sort LIMIT $jumlahDataPerHalaman OFFSET $awalData")->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main">
            <h1>Search Result</h1>
            <div class='sort-filter'>
                <h2>Sort and filter by:</h2>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class='sort'>
                        <label for="sort">Sort by:</label>
                        <select name="sort" id="sort">
                            <option value="JUDUL ASC">Title (A-Z)</option>
                            <option value="JUDUL DESC">Title (Z-A)</option>
                            <option value="TANGGAL_TERBIT ASC">Release Date (Ascending)</option>
                            <option value="TANGGAL_TERBIT DESC">Release Date (Descending)</option>
                        </select>
                    </div>
                    <div class='filter'>
                        <label for="filter">Filter by:</label>
                        <select name="filter" id="filter">
                            <?php foreach($genres as $genre): ?>
                                <option value="<?php echo $genre['genre']; ?>"><?php echo $genre['genre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="submit" value="OK" hidden>
                        <button class='submitbutton' type="submit" name="submit" value="OK">Submit</button>
                    </input>
                </form>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="submit" name="reset" value="OK" hidden>
                        <button class='submitbutton' type="submit" name="reset" value="OK">Reset</button>
                    </input>
                </form>
            </div>
            <div class='page'>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <label for="page">Page:</label>
                    <select name="page" id="page" onchange="this.form.submit();">
                        <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                            <?php if($i == $halamanAktif): ?>
                                <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>
            <div class="song-container">
                <?php foreach ($result as $song) : ?>
                        <?php $album = $conn->query("SELECT judul FROM album WHERE album_id = " . $song['album_id'])->fetch(PDO::FETCH_ASSOC); ?>
                        <div class='song'>
                            <a href="song.php?id=<?php echo $song['song_id']; ?>">
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