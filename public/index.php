<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOEIC Réponses</title>
    <style>
        .table-container {
            display: flex;
            justify-content: space-between;
        }

        table {
            border-collapse: collapse;
            margin: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .title {
            text-align: right;
        }

        
        .true {
            background-color: #00ff00; /* Couleur verte pour les réponses vraies */
            color: #ffffff; /* Texte en blanc pour une meilleure lisibilité */
        }

        .false {
            background-color: #ff0000; /* Couleur rouge pour les réponses fausses */
            color: #ffffff; /* Texte en blanc pour une meilleure lisibilité */
        }

        .btn-container {
            margin-top: 20px;
        }

        .btn-container button:disabled {
            background-color: #d3d3d3; /* Couleur grisée pour les boutons désactivés */
            cursor: not-allowed;
        }

        .result {
            position: absolute;
            top: 0;
            left: 0;
            font-weight: bold;
            padding: 5px;
        }
    </style>
</head>
<body>

<h1>TOEIC Réponses</h1>

<h2>Orales</h2>
<h2 class="title">Ecrits</h2>

<div class="btn-container">
    <button id="essaiBtn">Mode Essai</button>
    <button id="correctionBtn">Mode Correction</button>
</div>

<div class="table-container">
    <table id="orauxTable">
        <thead>
            <tr>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <th>Colonne <?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($row = 1; $row <= 25; $row++): ?>
                <tr>
                    <?php for ($col = 1; $col <= 4; $col++): ?>
                        <td data-row="<?= $row ?>" data-col="<?= $col ?>">
                            <?= ($row - 1) * 4 + $col ?>
                            <br>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="A"> A</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="B"> B</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="C"> C</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="D"> D</label>
                            <div class="result"></div>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <table id="ecritsTable">
        <thead>
            <tr>
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <th>Colonne <?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($row = 1; $row <= 25; $row++): ?>
                <tr>
                    <?php for ($col = 1; $col <= 4; $col++): ?>
                        <td data-row="<?= $row ?>" data-col="<?= $col ?>">
                            <?= ($row - 1) * 4 + $col ?>
                            <br>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="A"> A</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="B"> B</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="C"> C</label>
                            <label><input type="radio" name="colonne<?= ($row - 1) * 4 + $col ?>" value="D"> D</label>
                            <div class="result"></div>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var oraTable = document.getElementById('orauxTable');
        var ecriTable = document.getElementById('ecritsTable');
        var essaiBtn = document.getElementById('essaiBtn');
        var correctionBtn = document.getElementById('correctionBtn');

        var currentMode = 'essai'; // Par défaut, le mode essai est sélectionné

        essaiBtn.addEventListener('click', function () {
            currentMode = 'essai';
            updateModeButtons();
        });

        correctionBtn.addEventListener('click', function () {
            currentMode = 'correction';
            updateModeButtons();
        });

        function updateModeButtons() {
            essaiBtn.disabled = currentMode === 'essai';
            correctionBtn.disabled = currentMode === 'correction';
        }

        oraTable.addEventListener('click', function (event) {
            handleCellClick(event, oraTable);
        });

        ecriTable.addEventListener('click', function (event) {
            handleCellClick(event, ecriTable);
        });

        function handleCellClick(event, table) {
            var target = event.target;

            // Vérifier si le clic est sur une case à cocher
            if (target.type === 'radio') {
                var row = target.closest('td').getAttribute('data-row');
                var col = target.closest('td').getAttribute('data-col');

                // Ajouter/retirer la classe pour changer la couleur de fond
                toggleSelected(table, row, col);
            }
        }

        function toggleSelected(table, row, col) {
            // Retirer la classe de toutes les colonnes
            removeClassFromCols(table, 'selected-column', 'true', 'false');

            if (currentMode === 'essai') {
                // Si le mode essai est sélectionné, ajouter la classe 'selected-row'
                // à la ligne sélectionnée et 'selected-column' à la colonne sélectionnée
                addClassToRow(table, row, 'selected-row');
                addClassToColumn(table, col, 'selected-column');
            } else if (currentMode === 'correction') {
                // Si le mode correction est sélectionné, demander à l'utilisateur
                // de noter la réponse comme vraie ou fausse
                var isCorrect = confirm('La réponse est-elle correcte ?');

                // Ajouter la classe à la ligne et à la colonne sélectionnées
                addClassToRow(table, row, 'selected-row');

                if (isCorrect) {
                    // Si la réponse est correcte, ajouter la classe 'true'
                    addClassToCell(table, row, col, 'true');
                } else {
                    // Si la réponse est incorrecte, ajouter la classe 'false'
                    addClassToCell(table, row, col, 'false');
                }
            }
        }

        function removeClassFromCols(table, colClass, trueClass, falseClass) {
            var cells = table.getElementsByTagName('td');
            for (var i = 0; i < cells.length; i++) {
                cells[i].classList.remove(colClass, trueClass, falseClass);
            }
        }

        function addClassToRow(table, row, rowClass) {
            var rows = table.getElementsByTagName('tr');
            rows[row].classList.add(rowClass);
        }

        function addClassToCell(table, row, col, cellClass) {
            var cell = table.querySelector('td[data-row="' + row + '"][data-col="' + col + '"]');
            if (cell) {
                cell.classList.add(cellClass);
                cell.querySelector('.result').textContent = cellClass === 'true' ? 'Vrai' : 'Fausse';
            }
        }

        function addClassToColumn(table, col, colClass) {
            var cells = table.querySelectorAll('td[data-col="' + col + '"]');
            for (var i = 0; i < cells.length; i++) {
                cells[i].classList.add(colClass);
            }
        }
    });
</script>

</body>
</html>
