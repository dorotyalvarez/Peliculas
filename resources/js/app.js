import './bootstrap';

async function loadComponent(id, file) {
    try {
        const res = await fetch(file);
        if (!res.ok) throw new Error(`No se pudo cargar ${file}`);
        const html = await res.text();
        document.getElementById(id).innerHTML = html;
    } catch (error) {
        console.error(error);
        document.getElementById(id).innerHTML = `<p class="text-danger">Error al cargar ${file}</p>`;
    }
}

loadComponent("header", "header.html");
loadComponent("footer", "footer.html");

// 👇 Ojo: solo cargas main si esa página lo necesita
if (document.getElementById("main")) {
    loadComponent("main", "main.html");
}