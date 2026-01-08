<template>
  <div class="absences-page">
    <nav class="navbar">
      <a href="/etudiants">Étudiants</a> |
      <a href="/enseignants">Enseignants</a> |
      <a href="/absences" class="active">Absences</a> |
      <a href="/encadrements">Encadrements</a>
    </nav>
    <h1>Gestion des Absences</h1>

    <!-- Formulaire d'ajout -->
    <div class="add-container">
      <div class="absence-form card">
        <h3>Ajouter une absence</h3>
        <form @submit.prevent="submitForm">
          <div class="form-row">
            <div class="form-group">
              <label>Étudiant</label>
              <select v-model="form.etudiant_id" required>
                <option value="" disabled>Sélectionner un étudiant</option>
                <option v-for="etudiant in etudiants" :key="etudiant.id" :value="etudiant.id">
                  {{ etudiant.nom }} {{ etudiant.prenom }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Date</label>
              <input type="date" v-model="form.date" required>
            </div>
            <div class="form-group">
              <label>Motif</label>
              <input type="text" v-model="form.motif" placeholder="Raison de l'absence">
            </div>
            <div class="form-group btn-container">
              <button type="submit" class="btn-add">Enregistrer</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Étudiant</th>
          <th>Date</th>
          <th>Motif</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="absence in absences" :key="absence.id">
          <td>{{ absence.etudiant ? absence.etudiant.nom + ' ' + absence.etudiant.prenom : 'Inconnu' }}</td>
          <td>{{ new Date(absence.date).toLocaleDateString() }}</td>
          <td>{{ absence.motif || '-' }}</td>
          <td>
            <button @click="deleteAbsence(absence.id)" class="btn-delete">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { reactive } from 'vue'

export default {
  name: "Absences",
  props: {
    absences: Array,
    etudiants: Array
  },
  setup(props) {
    const form = reactive({
      etudiant_id: '',
      date: new Date().toISOString().substr(0, 10),
      motif: ''
    })

    const submitForm = () => {
      Inertia.post('/absences', { ...form }, {
        onSuccess: () => {
          form.etudiant_id = ''
          form.motif = ''
        }
      })
    }

    const deleteAbsence = (id) => {
      if (confirm('Supprimer cette absence ?')) {
        Inertia.delete(`/absences/${id}`)
      }
    }

    return {
      form,
      submitForm,
      deleteAbsence
    }
  }
}
</script>

<style scoped>
.absences-page {
  font-family: Arial, sans-serif;
  background-color: #f2f7f9;
  margin: 20px;
  padding-bottom: 50px;
}

.navbar {
  background: #2c3e50;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
  color: white;
  text-align: center;
}

.navbar a {
  color: #ecf0f1;
  text-decoration: none;
  margin: 0 10px;
  font-weight: bold;
}

.navbar a:hover {
  color: #27ae60;
}

.navbar a.active {
  color: #27ae60;
  text-decoration: underline;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

.add-container {
  max-width: 90%;
  margin: 0 auto 30px;
}

.absence-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.absence-form h3 {
  margin-top: 0;
  margin-bottom: 20px;
  color: #27ae60;
}

.form-row {
  display: flex;
  gap: 20px;
  align-items: flex-end;
  flex-wrap: wrap;
}

.form-group {
  flex: 1;
  min-width: 200px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input, .form-group select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-container {
  flex: 0;
}

table {
  width: 90%;
  margin: 0 auto;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  background-color: #fff;
}

th, td {
  padding: 12px 15px;
  text-align: left;
}

thead {
  background-color: #27ae60;
  color: #fff;
  text-transform: uppercase;
  font-size: 14px;
}

tbody tr {
  border-bottom: 1px solid #ddd;
}

tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

tbody tr:hover {
  background-color: #f1f7fc;
}

.btn-add {
  background-color: #27ae60;
  color: #fff;
  padding: 11px 25px;
  border-radius: 5px;
  font-size: 14px;
  border: none;
  cursor: pointer;
  transition: 0.3s ease;
}

.btn-add:hover {
  background-color: #219150;
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
</style>
