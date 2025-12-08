// ===== RELÓGIO NO TOPO =====
function updateClock() {
  const timeEl = document.querySelector(".clock-time");
  const dateEl = document.querySelector(".clock-date");

  if (!timeEl || !dateEl) return; // segurança, caso algo mude no HTML

  const now = new Date();

  const pad = (n) => String(n).padStart(2, "0");

  const hours = pad(now.getHours());
  const minutes = pad(now.getMinutes());
  const seconds = pad(now.getSeconds());

  timeEl.textContent = `${hours}:${minutes}:${seconds}`;

  const weekdays = [
    "Domingo",
    "Segunda-Feira",
    "Terça-Feira",
    "Quarta-Feira",
    "Quinta-Feira",
    "Sexta-Feira",
    "Sábado",
  ];

  const months = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
  ];

  const weekday = weekdays[now.getDay()];
  const day = now.getDate();
  const month = months[now.getMonth()];
  const year = now.getFullYear();

  dateEl.textContent = `${weekday}, ${day} de ${month} de ${year}`;
}

setInterval(updateClock, 1000);
updateClock();

// ===== FILTROS DE CATEGORIA (PILLS) =====
const pills = document.querySelectorAll(".pill");
const cards = document.querySelectorAll(".card");

function applyFilter(filter) {
  cards.forEach((card) => {
    const category = card.dataset.category; // data-category no HTML

    if (filter === "todos" || filter === category) {
      card.style.display = "";
    } else {
      card.style.display = "none";
    }
  });
}

// Ativa clique nos botões de filtro
pills.forEach((pill) => {
  pill.addEventListener("click", () => {
    // visual: qual pill está ativa
    pills.forEach((p) => p.classList.remove("pill-active"));
    pill.classList.add("pill-active");

    const filter = pill.dataset.filter; // data-filter no HTML
    applyFilter(filter);
  });
});

// Aplica filtro inicial (Todos)
applyFilter("todos");

// ===== COMPORTAMENTO DOS CARDS (LINKS VAZIOS) =====
cards.forEach((card) => {
  card.addEventListener("click", (event) => {
    const href = card.getAttribute("href");

    // Se o href estiver vazio, não deixa "recarregar" a página
    if (!href || href.trim() === "") {
      event.preventDefault();
      alert("Este sistema ainda não possui link configurado.");
    }
    
  });
});
