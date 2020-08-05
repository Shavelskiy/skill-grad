const add = document.querySelectorAll('.add-category');
add.forEach(item => {
  item.addEventListener('click', () => {
    const block = item.parentNode.querySelector('.block-add-category');
    block.classList.toggle('active');
  });
});
