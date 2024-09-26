<
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .containerE {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #F08080;
            text-align: center;
        }
        form {
            background-color: #F08080;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: white;
            color: #F08080;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #F08080;
            color: white;
        }
    </style>
    <div class="containerE">
        <h1>Cadastro de animais</h1>
        <form action="process.php" method="post">
            <label for="name">Nome do animal:</label>
            <input type="text" id="name" name="name" required>

            <label for="especie">Espécie:</label>
            <input type="text" id="especie" name="especie"><br>

            <label for="raca">Raça:</label>
            <input type="text" id="raca" name="raca"><br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0"><br>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo">

            <option value="M">Macho</option>
            <option value="F">Fêmea</option>
            </select><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento"><br>
            <input type="submit" value="Atualizar">     
        </form>
    </div>
