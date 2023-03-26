<!DOCTYPE html>
<html>
<head>
    <title>Contoh REST Country API</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Contoh REST Country API</h2>
    <p>Masukkan nama negara untuk mendapatkan detail negara:</p>
    <form>
        <div class="form-group">
            <label for="country">Nama Negara:</label>
            <input type="text" class="form-control" id="country" placeholder="Masukkan nama negara" name="country">
        </div>
        <button type="button" class="btn btn-primary" id="btnSearch">Cari</button>
    </form>
    <div id="result"></div>
</div>

<script>
    $(document).ready(function(){
        $("#btnSearch").click(function(){
            var countryName = $("#country").val();
            $.ajax({
                url: "https://restcountries.com/v3.1/name/" + countryName,
                type: "GET",
                success: function(result){
                    $("#result").html("<p><strong>Nama Negara:</strong> " + result[0].name.common + "</p>" +
                        "<p><strong>Ibu Kota:</strong> " + result[0].capital[0] + "</p>" +
                        "<p><strong>Wilayah:</strong> " + result[0].region + "</p>" +
                        "<p><strong>Populasi:</strong> " + result[0].population + "</p>" +
                        "<p><strong>Mata Uang:</strong> " + Object.keys(result[0].currencies)[0] + " (" + result[0].currencies[Object.keys(result[0].currencies)[0]].name + ")</p>");
                },
                error: function(xhr, status, error) {
                    $("#result").html("<p><strong>Error:</strong> " + xhr.responseText + "</p>");
                }
            });
        });
    });
</script>

</body>
</html>
