const songs = document.getElementById("songs");
const penyanyi = document.getElementById("penyanyi");

const getPenyanyi = async () => {
    const response = await fetch("http://localhost:3000/users/2",
    {
        method: "GET",
    }).then((response) => response.json());
    renderPenyanyi(response);
    console.log(response);
}

const getPremiumSongs = async () => {
    const response = await fetch("http://localhost:3000/users/2/songs").then((response) => response.json());
    renderPremiumSongs(response);
    console.log(response);
}

const renderPremiumSongs = async (data) => {
    songs.innerHTML = "";
    
    data.forEach((song, i)=> {
        const { id, judul, penyanyi_id, audio_path } = song;
        const card = document.createElement("div");
        card.classList.add("song");
        card.innerHTML = `
            <p>${i+1}</p>
            <p style="width: 87%">${judul}</p>
            <p style="text-align: right">
                <a href="detailLagu.php?song_id=<?= $song['song_id'] ?>">
                    <img src="img/play.png" class="play-but" alt="play" />
                </a>
            </p>
        `;
        songs.appendChild(card);
    })
}

const renderPenyanyi = async (data) => {
    penyanyi.innerHTML = "";

    const { email, isadmin, name, password, user_id, username } = data;
    const card = document.createElement("div");
    card.classList.add("penyanyi");
    card.innerHTML = `
        <p>${name}</p>
    `;
    penyanyi.appendChild(card);
}

getPenyanyi();
getPremiumSongs();