let myForm = document.querySelector('form.form');

myForm.addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(myForm);
    formData.append('action', 'ajax_mail');
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
    }).then(response => {
        if (response.status !== 200) {
            return Promise.reject();
        }
        return response.text();
    }).then(answer => {
        console.log(answer);
        myForm.reset();
    }).catch(
        () => console.log('error')
    );
});