const menu = document.querySelector('.menu');
const NavMenu = document.querySelector('.nav-menu');

menu.addEventListener('click', () => {
    menu.classList.toggle('ativo');
    NavMenu.classList.toggle('ativo');
})


const userIcon = document.querySelector('.bx-user');
const modal = document.getElementById('userModal');

userIcon.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Fechar o modal ao clicar fora do conteúdo
modal.addEventListener('click', (e) => {
    if (e.target == modal) {
        modal.style.display = 'none';
    }
});

// Se você deseja que o usuário deslogue ao clicar no ícone vermelho dentro do modal:
document.querySelector('.modal-content i').addEventListener('click', () => {
    // Aqui você pode chamar qualquer função que realize o logout do usuário.
    // Por exemplo: logoutFunction();

    // Por enquanto, só vou ocultar o modal:
    modal.style.display = 'none';
});

const profileButton = document.querySelector('.profile-button');

profileButton.addEventListener('click', () => {
    // Supondo que a página do perfil seja "perfil.html"
    window.location.href = 'perfil.html';
});


