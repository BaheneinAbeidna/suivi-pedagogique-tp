<!DOCTYPE html>
<html>
<head>
    <title>Liste des Enseignants</title>
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

        /* Add button */
        .btn-add {
            display: inline-block;
            padding: 10px 16px;
            background-color: #3498db;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 14px;

        }

        .btn-add:hover {
            background-color: #217dbb;
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

        /* Student list cell */
        .students {
            font-size: 14px;
            line-height: 1.4;
        }

        /* Action buttons */
        .btn-edit {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-edit:hover {
            text-decoration: underline;
        }

        .btn-delete {
            color: #e74c3c;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-delete:hover {
            text-decoration: underline;
        }
        .add-container {
    text-align: right;
    margin-right: 65px; /* space from the left side */
    margin-bottom: 20px;
}

.btn-add {
    display: inline-block;
    background-color: #3498db;
    color: #fff;
    padding: 10px 18px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s ease;
}

.btn-add:hover {
    background-color: #3498db;
}

    </style>
</head>

<body>

<h1>Liste des Enseignants</h1>

<div class="add-container">
    <a href="{{ route('enseignants.create') }}" class="btn-add">Ajouter un enseignant</a>
</div>


<table>
    <thead>
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Spécialité</th>
            <th>Étudiants encadrés</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($enseignants as $ens)
            <tr>
                <td>{{ $ens->matricule }}</td>
                <td>{{ $ens->nom }}</td>
                <td>{{ $ens->prenom }}</td>
                <td>{{ $ens->specialite }}</td>

                <td class="students">
                    @if($ens->etudiants->count() == 0)
                        Aucun étudiant
                    @else
                        @foreach($ens->etudiants as $e)
                            - {{ $e->nom }} {{ $e->prenom }} ({{ $e->matricule }}) <br>
                        @endforeach
                    @endif
                </td>

                <td>
                    <a href="{{ route('enseignants.edit', $ens->id) }}" class="btn-edit"> Modifier</a>
                    |
                    <form action="{{ route('enseignants.destroy', $ens->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Supprimer cet enseignant ?')" class="btn-delete">
                             Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
