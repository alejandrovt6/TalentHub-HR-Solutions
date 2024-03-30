// Obtener año actual (footer)
const currentYearElement = document.getElementById('currentYear');

const currentYear = new Date().getFullYear();

currentYearElement.textContent = currentYear;
