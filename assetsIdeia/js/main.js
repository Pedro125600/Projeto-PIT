/// Variáveis de seleção de elementos
const menu = document.querySelector('.menu');
const NavMenu = document.querySelector('.nav-menu');
const userIcon = document.querySelector('.bx-user');
const modal = document.getElementById('userModal');
const profileButton = document.querySelector('.profile-button');
const followButton = document.querySelector('.follow-button');

// Evento de clique para mostrar/ocultar o menu
menu.addEventListener('click', () => {
    menu.classList.toggle('ativo');
    NavMenu.classList.toggle('ativo');
});

// Evento de clique no ícone de usuário para mostrar o modal
userIcon.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Fechar o modal ao clicar fora dele
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

// Evento de clique no botão de perfil
profileButton.addEventListener('click', () => {
    // Redirecionar para a página de perfil (supondo que seja 'perfil.html')
    window.location.href = 'perfil.html';
});

// Evento de clique no botão de seguir
followButton.addEventListener('click', () => {
    if (!followButton.classList.contains('following')) {
        followButton.classList.add('following');
        followButton.innerHTML = '<i class="bx bx-check"></i> Seguindo';
    } else {
        followButton.classList.remove('following');
        followButton.innerHTML = '<i class="bx bx-user-plus"></i> Seguir';
    }
});

// Variáveis de seleção de elementos para os novos modais personalizados
const apoioCustomButton = document.querySelector('.apoio-custom-button');
const parceriaCustomButton = document.querySelector('.parceria-custom-button');
const apoioCustomModal = document.getElementById('apoioCustomModal');
const parceriaCustomModal = document.getElementById('parceriaCustomModal');

// Eventos para os novos modais personalizados
apoioCustomButton.addEventListener('click', () => {
    apoioCustomModal.style.display = 'flex';
});

parceriaCustomButton.addEventListener('click', () => {
    parceriaCustomModal.style.display = 'flex';
});

                        