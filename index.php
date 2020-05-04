<?php
    session_start();

    if(!isset($_SESSION['sendtime']) || empty($_SESSION['sendtime'])) {
        $_SESSION['sendtime'] = time();
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

</head>

<body style="background: url('assets/images/background.jpg'); background-size: cover">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <div class="container py-5">
        <div class="row d-flex justify-content-left">

            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        
                    </div>
                    <div class="card-body">
                        <form id="form" action="">
                            <div class="form-group">
                                <h6 class="text-center text-light">შეიყვანე ნომერი</h6>
                            </div>
                            <div class="form-group py-3">
                                <input type="number" class="form-control bg-secondary text-white" name="number" required>
                            </div>
                            <hr>
                            <div class="form-group">
                                <button class="btn btn-danger w-100" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modaler" tabindex="-1" role="dialog" aria-labelledby="modalerLab" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="modalerLab">ინფორმაცია მოხმარებელზე</h5>
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-5">
                            <img id="modal-img" class="w-100" src="assets/images/noimage.png">
                        </div>
                        <div class="col">
                            <h5 id="modal-name">No name</h5>
                            <p id="modal-phone">404 404 404</p>
                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>

    <script>
    let form = $('#form');


    form.submit(function(e) {
        e.preventDefault();

        let inputs = form.serializeArray();
        let input = inputs[0].value;

        $('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: 'ajax.php',
            type: 'GET',
            data: {number: input},
            dataType: 'json',
            success: function(data) {

                console.log(data)

                if(data.res == "yes")
                {
                    let info = data.info;
                    $('#modal-img').attr('src', info.image != "" ? info.image : 'assets/images/noimage.png' );
                    $('#modal-name').text( info.name );
                    $('#modal-phone').text( data.valid_number );
                    $('#modaler').modal('show');
                } else {
                    if(data.err == 'timelimit') {
                        alert('გთხოვთ დაიცადოთ '+data.seconds + ' წამი ...');
                    } else {
                        alert('ინფორმაცია ნომერზე('+input+') ვერ მოიძებნა: Error Code: '+data.err);
                    }
                }
            }
        });

    });
    
    </script>

</body>
</html>