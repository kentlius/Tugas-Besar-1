const main = document.getElementById("main");

const getListPenyanyi = async () => {
    const response = await fetch("http://localhost:3000/users",
    {
        method: "GET",
    }).then((response) => response.json());
    renderListPenyanyi(response);
}

const renderListPenyanyi = async (data) => {
    main.innerHTML = "";

    data.forEach((penyanyi, i)=> {
        const { userid, name } = penyanyi;
        const card = document.createElement("div");
        card.classList.add("penyanyi");
        card.innerHTML = `
            <p>${i+1}</p>
            <p>${name}</p>
            <button class="subscribe" name="subscribe" value="${userid}">
                    Subscribe
            </button>
        `;
        main.appendChild(card);

    })
}

getListPenyanyi();
