<!DOCTYPE html>
<html>
<head>
    <title>Liste des Étudiants</title>
    @vite('resources/css/app.css')

    <style>

        /* General page style */
body {
    font-family: Arial, sans-serif;
    background-color: #f2f7f9;
    margin: 20px;
}

/* Page header */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

/* Table styling */
table {
    width: 90%;
    margin: 0 auto;
    border-collapse: collapse;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    background-color: #fff;
}

/* Table cells */
th, td {
    padding: 12px 15px;
    text-align: left;
}

/* Table header */
thead {
    background-color: #3498db;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

/* Table rows */
tbody tr {
    border-bottom: 1px solid #ddd;
}

/* Stripe effect */
tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover effect */
tbody tr:hover {
    background-color: #f1f7fc;
}

        </style>

</head>
<body>

<h1>Liste des Étudiants </h1>

<table border="1" cellpad ding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Filière</th>
            <th>Niveau</th>
        </tr>
    </thead>

    <tbody>
        @foreach($etudiants as $e)
            <tr>
                <td>{{ $e->matricule }}</td>
                <td>{{ $e->nom }}</td>
                <td>{{ $e->prenom }}</td>
                <td>{{ $e->filiere }}</td>
                <td>{{ $e->niveau }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
