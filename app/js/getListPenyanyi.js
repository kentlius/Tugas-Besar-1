const listPenyanyi = document.getElementById("listPenyanyi");

const getListPenyanyi = async () => {
    const response = await fetch("http://localhost:3000/penyanyi").then((response) => response.json());
    
    }


