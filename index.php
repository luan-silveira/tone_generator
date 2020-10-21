<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de tons - WAV</title>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 20px; width: 700px">
        <h2>Gerador de tons - WAV</h2>

        <div class="jumbotron" style="margin-top: 30px; padding: 2rem 2rem">
            <form id="form">
                <div class="form-group">
                    <label for="freq">Frequência (Hz)</label>
                    <input class="form-control" style="width: 200px;" value="440" type="number" name="freq" id="freq" min="20" max="20000">
                </div>

                <div class="form-group">
                    <label for="freq">Duração (s)</label>
                    <input class="form-control" style="width: 200px;" value="5" type="number" name="tempo" id="tempo" min="1" max="60000">
                </div>

                <div class="form-group">
                    <label for="freq">Taxa de Amostragem</label>
                    <select class="form-control" name="taxa" id="taxa" style="width: 150px;">
                        <option value="22050">22.050 Hz</option>
                        <option value="44100" selected>44.100 Hz</option>
                        <option value="48000">48.000 Hz</option>
                        <option value="96000">96.000 Hz</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="freq">Taxa de Bits por Amostra</label>
                    <select class="form-control" name="bits" id="bits" style="width: 150px;">
                        <option value="8">8 bits</option>
                        <option value="16" selected>16 bits</option>
                        <option value="24">24 bits</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Gerar</button>

                <div class="alert alert-info" id="divInfo" style="display: none; margin-top: 20px;"></div>
            </form>
        </div>
    </div>
</body>

</html>