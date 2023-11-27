window.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('CPF');
    const telInput = document.getElementById('number');

    cpfInput.addEventListener('input', handleCPFInput);
    telInput.addEventListener('input', handleTelInput);

    function handleCPFInput(event) {
        let value = event.target.value;
        value = value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        event.target.value = value;
    }

    function handleTelInput(event) {
        let value = event.target.value;
        value = value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        event.target.value = value;
    }
});