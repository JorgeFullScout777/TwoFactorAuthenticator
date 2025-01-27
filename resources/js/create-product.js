const createBtn = document.getElementById('create-btn');
const cancelBtn = document.getElementById('cancel-btn');
const bolasDiv = document.querySelector('.bolas');

createBtn.addEventListener('click', () => {
    bolasDiv.style.display = 'flex';
    createBtn.style.display = 'none';
});

cancelBtn.addEventListener('click', () => {
    bolasDiv.style.display = 'none';
    createBtn.style.display = 'block';
    console.log('Cancel button clicked');
});