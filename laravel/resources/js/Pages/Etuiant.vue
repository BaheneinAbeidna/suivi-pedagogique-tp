<template>
<div class="container mt-5">
<h2>Liste des étudiants</h2>
<table class="table">
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
<tr v-for="etudiant in etudiants" :key="etudiant.id">
<td>{{ etudiant.matricule }}</td>
<td>{{ etudiant.nom }}</td>
<td>{{ etudiant.prenom }}</td>
<td>{{ etudiant.filiere }}</td>
<td>{{ etudiant.niveau }}</td>
</tr>
</tbody>
</table>
</div>
</template>
<script setup>
defineProps({ etudiants: Array })
</script>