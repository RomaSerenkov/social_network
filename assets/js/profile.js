$(document).ready(function () {
    $(document).on("click", "#editModalButton", function () {
        fetch('/profile/edit')
            .then(response => response.json())
            .then(data => {
                $("#exampleModal").html(data.html);
                $("#exampleModal").modal('toggle');
            });
    });

    $(document).on("click", "#saveChangeButton", function () {
        let firstName = $("#profile_form_firstName").val();
        let lastName  = $("#profile_form_lastName").val();
        let birthday  = $("#profile_form_birthday").val();
        let file      = $("#profile_form_image")[0].files[0];
        let token     = $("#profile_form__token").val();

        let data = new FormData();
        data.append('profile_form[firstName]', firstName);
        data.append('profile_form[lastName]', lastName);
        data.append('profile_form[birthday]', birthday);
        data.append('profile_form[image]', file);
        data.append('profile_form[_token]', token);

        fetch('/profile/edit', {
            method: 'POST',
            body: data
        })
            .then(response => response.json())
            .then(data => {
                $("#profilePage").html(data.html);
                $("#exampleModal").modal('toggle');
            })
            .catch(
                error => console.log(error)
            );
    });

    $(document).on("click", "#editImage", function () {
        $('#profile_form_image').toggleClass("d-none");
    });

    $(document).on("click", "#deleteImage", function () {
        fetch('/profile/deleteImage')
            .then(response => response.json())
            .then(data => {
                $('#userImage').addClass("d-none");
                $('#profile_form_image').toggleClass("d-none");
            });
    });
});
