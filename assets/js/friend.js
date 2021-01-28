$(document).ready(function () {
    let offset = 0;
    let rowPerPage;
    let countUsers;

    findUsers('/friends/findAllPeople', 'GET');

    let debounceFunction = function (func, delay) {
        let timerId;
        clearTimeout(timerId)
        timerId = setTimeout(func, delay)
    }

    // ajax request to keyup input search
    $(document).on("input", "#searchPeople", function () {
        offset = 0;
        let data = new FormData();
        data.append("firstName", $(this).val());

        debounceFunction(() => {
            findUsers('/friends/findByFirstName', 'POST', data);
        }, 400);
    });


    function findUsers(url, method, postData = null)
    {
        $('#loader').toggleClass("d-none");
        $('#findFriends').css('opacity', '0.2');

        fetch(url, {
            method: method,
            body: postData
        })
            .then(response => response.json())
            .then(data => {
                if (typeof data.rowPerPage !== 'undefined') {
                    rowPerPage = data.rowPerPage;
                }

                if (typeof data.countUsers !== 'undefined') {
                    countUsers = data.countUsers;
                }

                if (offset == 0) {
                    $("#findFriends").html(data.html);
                } else {
                    $("#findFriends").append(data.html);
                }

                $('#loader').toggleClass("d-none");
                $('#findFriends').css('opacity', '1');
            })
            .catch(
                error => console.log(error)
            );
    }

    // ajax request to end page
    $(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            if (countUsers >= offset + rowPerPage) {
                offset += rowPerPage;
                let data = new FormData();
                data.append("offset", offset);
                data.append("firstName", $('#searchPeople').val());

                findUsers('/friends/findByFirstName', 'POST', data);
            }
        }
    });
});
