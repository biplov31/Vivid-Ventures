const sortBtn = document.querySelector('.sort-btn');
const sortingOptions = document.querySelector('.sorting-options');
sortBtn.addEventListener('click', () => {
  sortBtn.classList.toggle('active');
  sortingOptions.classList.toggle('show');
})


const deleteButtons = document.querySelectorAll('.delete-event-btn');
Array.from(deleteButtons).forEach(deleteButton => {
  deleteButton.addEventListener('click', async () => {
    const packageId = deleteButton.value;
    const response = await fetch(`http://localhost/vivid-ventures/controllers/managePackage.php?package_id=${packageId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
      }
    })
    const data = await response.json();
    console.log(data);
    if (response.ok) {
      console.log("Package deleted.");
    }
  })
})