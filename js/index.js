// index.js

function menuInit() {
    // Шаг 1: Пытаемся найти элементы
    var dropdown = document.getElementById("dropdown-item");
    var submenu = document.getElementById("submenu");

    // Шаг 2: ВАЖНАЯ ПРОВЕРКА!
    // Если оба элемента (и главный пункт, и подменю) были найдены на странице...
    if (dropdown && submenu) {
        
        // ...только тогда мы вешаем на них обработчики событий.
        dropdown.onmouseover = popOutMenu;
        dropdown.onmouseout = hideDropdown;

        submenu.onmouseover = popOutMenu;
        submenu.onmouseout = hideDropdown;
    }
    
    // Если элементы не найдены, то этот блок кода просто не выполнится, и ошибки не будет.
}


function popOutMenu () {
    submenu.className = "show-submenu";
}

function hideDropdown () {
    submenu.className = "hide-submenu";
}