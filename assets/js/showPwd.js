const showPwd = document.getElementById('showPwd');
const pwd = document.getElementById('pwd');

showPwd.addEventListener('change', ({ target }) => {

    pwd.type = target.checked ? 'text' : 'password';
});