<template>
  <div class="encadrements-page">
    <nav class="navbar">
      <a href="/etudiants">Étudiants</a> |
      <a href="/enseignants">Enseignants</a> |
      <a href="/absences">Absences</a> |
      <a href="/encadrements" class="active">Encadrements</a>
    </nav>
    <h1>Gestion de l'Encadrement des Étudiants</h1>

    <!-- Formulaire d'ajout -->
    <div class="add-container">
      <div class="encadrement-form card">
        <h3>Assigner un étudiant à un enseignant</h3>
        <form @submit.prevent="submitForm">
          <div class="form-row">
            <div class="form-group">
              <label>Étudiant</label>
              <select v-model="form.etudiant_id" required>
                <option value="" disabled>Sélectionner un étudiant</option>
                <option v-for="etudiant in etudiants" :key="etudiant.id" :value="etudiant.id">
                  {{ etudiant.matricule }} - {{ etudiant.nom }} {{ etudiant.prenom }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Enseignant</label>
              <select v-model="form.enseignant_id" required>
                <option value="" disabled>Sélectionner un enseignant</option>
                <option v-for="enseignant in enseignants" :key="enseignant.id" :value="enseignant.id">
                  {{ enseignant.nom }} {{ enseignant.prenom }}
                </option>
              </select>
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
          <th>Matricule Étudiant</th>
          <th>Nom Étudiant</th>
          <th>Enseignant</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="encadrement in encadrements" :key="encadrement.id">
          <td>{{ encadrement.etudiant ? encadrement.etudiant.matricule : '-' }}</td>
          <td>{{ encadrement.etudiant ? encadrement.etudiant.nom + ' ' + encadrement.etudiant.prenom : 'Inconnu' }}</td>
          <td>{{ encadrement.enseignant ? encadrement.enseignant.nom + ' ' + encadrement.enseignant.prenom : 'Inconnu' }}</td>
          <td>
            <button @click="deleteEncadrement(encadrement.id)" class="btn-delete">Supprimer</button>
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
  name: "Encadrements",
  props: {
    encadrements: Array,
    etudiants: Array,
    enseignants: Array
  },
  setup(props) {
    const form = reactive({
      etudiant_id: '',
      enseignant_id: ''
    })

    const submitForm = () => {
      Inertia.post('/encadrements', { ...form }, {
        onSuccess: () => {
          form.etudiant_id = ''
          form.enseignant_id = ''
        }
      })
    }

    const deleteEncadrement = (id) => {
    
        Inertia.delete(`/encadrements/${id}`)
      
    }

    return {
      form,
      submitForm,
      deleteEncadrement
    }
  }
}
</script>

<style scoped>
.encadrements-page {
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

.encadrement-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.encadrement-form h3 {
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
