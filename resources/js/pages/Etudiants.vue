<template>
  <div class="etudiants-page">
    <nav class="navbar">
      <a href="/etudiants" class="active">Étudiants</a> |
      <a href="/enseignants">Enseignants</a> |
      <a href="/absences">Absences</a> |
      <a href="/encadrements">Encadrements</a>
    </nav>
    <h1>Liste des Étudiants</h1>

    <div class="add-container">
      <button class="btn-add" @click="openModal('add')">Ajouter un étudiant</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Matricule</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Filière</th>
          <th>Niveau</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="etudiant in etudiants" :key="etudiant.id">
          <td>{{ etudiant.matricule }}</td>
          <td>{{ etudiant.nom }}</td>
          <td>{{ etudiant.prenom }}</td>
          <td>{{ etudiant.filiere }}</td>
          <td>{{ etudiant.niveau }}</td>
          <td>
            <button @click="openModal('edit', etudiant)" class="btn-edit">Modifier</button>
            |
            <button @click="deleteEtudiant(etudiant.id)" class="btn-delete">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal">
        <h2>{{ modalMode === 'add' ? 'Ajouter Étudiant' : 'Modifier Étudiant' }}</h2>
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label>Matricule</label>
            <input type="text" v-model="form.matricule" required>
          </div>
          <div class="form-group">
            <label>Nom</label>
            <input type="text" v-model="form.nom" required>
          </div>
          <div class="form-group">
            <label>Prénom</label>
            <input type="text" v-model="form.prenom" required>
          </div>
          <div class="form-group">
            <label>Filière</label>
            <input type="text" v-model="form.filiere">
          </div>
          <div class="form-group">
            <label>Niveau</label>
            <input type="text" v-model="form.niveau">
          </div>

          <div class="modal-buttons">
            <button type="submit" class="btn-add">{{ modalMode === 'add' ? 'Ajouter' : 'Mettre à jour' }}</button>
            <button type="button" @click="closeModal" class="btn-delete">Annuler</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { reactive, ref } from 'vue'

export default {
  name: "Etudiants",
  props: {
    etudiants: Array
  },
  setup(props) {
    const showModal = ref(false)
    const modalMode = ref('add') // 'add' or 'edit'

    const form = reactive({
      id: null,
      matricule: '',
      nom: '',
      prenom: '',
      filiere: '',
      niveau: ''
    })

    const openModal = (mode, etudiant = null) => {
      modalMode.value = mode
      if (mode === 'edit' && etudiant) {
        form.id = etudiant.id
        form.matricule = etudiant.matricule
        form.nom = etudiant.nom
        form.prenom = etudiant.prenom
        form.filiere = etudiant.filiere
        form.niveau = etudiant.niveau
      } else {
        form.id = null
        form.matricule = ''
        form.nom = ''
        form.prenom = ''
        form.filiere = ''
        form.niveau = ''
      }
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
    }

    const submitForm = () => {
      if (modalMode.value === 'add') {
        Inertia.post('/etudiants', { ...form })
      } else {
        Inertia.put(`/etudiants/${form.id}`, { ...form })
      }
      closeModal()
    }

    const deleteEtudiant = (id) => {
      if (confirm('Supprimer cet étudiant ?')) {
        Inertia.delete(`/etudiants/${id}`)
      }
    }

    return {
      showModal,
      modalMode,
      form,
      openModal,
      closeModal,
      submitForm,
      deleteEtudiant
    }
  }
}
</script>

<style scoped>
/* general page style */
.etudiants-page {
  font-family: Arial, sans-serif;
  background-color: #f2f7f9;
  margin: 20px;
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

/* page header */
h1 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

/* table styling */
table {
  width: 90%;
  margin: 0 auto;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  background-color: #fff;
}

/* table cells */
th, td {
  padding: 12px 15px;
  text-align: left;
}

/* table header */
thead {
  background-color: #27ae60;
  color: #fff;
  text-transform: uppercase;
  font-size: 14px;
}

/* table rows */
tbody tr {
  border-bottom: 1px solid #ddd;
}

/* stripe effect */
tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

/* hover effect */
tbody tr:hover {
  background-color: #f1f7fc;
}

/* action buttons */
.btn-add {
  display: inline-block;
  background-color: #27ae60;
  color: #fff;
  padding: 10px 18px;
  border-radius: 5px;
  text-decoration: none;
  font-size: 14px;
  transition: 0.3s ease;
  border: #27ae60;
}

.btn-add:hover {
  background-color: #219150;
}

.btn-edit {
  color: #f39c12;
  text-decoration: none;
  font-weight: bold;
  border: none;
  background: none;
  cursor: pointer;
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

/* modal overlay */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

/* modal box */
.modal {
  background-color: #fff;
  padding: 20px 30px;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 7px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

/* add-container */
.add-container {
  text-align: right;
  margin-right: 65px;
  margin-bottom: 20px;
}

</style>
