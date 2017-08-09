// Function for adding a new file. Confirms the pmid exists in verify_add.php and changes to a submit form
$(function () {
    $('form.ajax').on('submit', function (e) {
        $.ajax({
            type: 'post',
            url: 'model/verify_add.php',
            data: $('form.ajax').serialize(),
            success: function (data) {
//                alert("Added article with PMID: " + data);
                if (data.length < 5000) { // More implies an error occurred

//                    var objJSON = JSON.parse(data);
                    document.getElementById('pre_ajax').style['display'] = 'none';
                    document.getElementById('post_ajax').style['display'] = 'block';
//                    document.getElementById('ajax_author').innerHTML = objJSON['author'] + ", " + objJSON['pubdate'];
//                    document.getElementById('pmid_ajax').value = objJSON['newid'];
                    document.getElementById('pmid_ajax').value = data;
//                    console.log( document.getElementById('pmid_ajax').value);
                }

            }
        });
        e.preventDefault();
    });
});