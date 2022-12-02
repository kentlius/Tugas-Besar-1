const songs = document.getElementById("songs");
const penyanyi = document.getElementById("penyanyi");
const penyanyiID = document.getElementById("dom-target").textContent;

const getPenyanyi = async (penyanyiID) => {
  const response = await fetch(`http://localhost:3000/users/${penyanyiID}`, {
    method: "GET",
  }).then((response) => response.json());
  renderPenyanyi(response);
  console.log(response);
};

const getPremiumSongs = async (penyanyiID) => {
  const response = await fetch(
    `http://localhost:3000/users/${penyanyiID}/songs`
  ).then((response) => response.json());
  renderPremiumSongs(response);
};

const renderPremiumSongs = async (data) => {
  songs.innerHTML = "";

  data.forEach((song, i) => {
    console.log(song);
    console.log(i + "hai");
    const { song_id, judul, penyanyi_id, audio_path } = song;
    const card = document.createElement("div");
    card.classList.add("song");
    card.innerHTML = `
            <p>${i + 1}</p>
            <p style="width: 87%">${judul}</p>
            <a style="text-align: right" href="#popup1" id="${song_id}">
                <img src="img/play.png" class="play-but" alt="play" />
            </a>
        `;
    songs.appendChild(card);

    const playBut = document.getElementById(song_id);
    playBut.addEventListener("click", () => {
      openPopup(song);
    });
  });
};

const openPopup = async (song) => {
  console.log(song);
  const { song_id, judul, penyanyi_id, audio_path } = song;
  const judulLagu = document.getElementById("judul-lagu-popup");
  const audio = document.getElementById("audioplay");
  judulLagu.innerHTML = judul;
  audio.innerHTML = `<source src="${audio_path}" type='audio/mpeg'></source>`;
};

const renderPenyanyi = async (data) => {
  penyanyi.innerHTML = "";

  const { email, isadmin, name, password, user_id, username } = data;
  const card = document.createElement("div");
  card.classList.add("penyanyi");
  card.innerHTML = `
        <p>${name}</p>
    `;
  penyanyi.appendChild(card);
};

getPenyanyi(penyanyiID);
getPremiumSongs(penyanyiID);
