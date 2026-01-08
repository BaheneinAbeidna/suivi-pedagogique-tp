<template>
  <div class="enseignants-page">
    <nav class="navbar">
      <a href="/etudiants">Étudiants</a> |
      <a href="/enseignants" class="active">Enseignants</a> |
      <a href="/absences">Absences</a> |
      <a href="/encadrements">Encadrements</a>
    </nav>
    <h1>Liste des Enseignants</h1>

    <div class="add-container">
      <button class="btn-add" @click="openModal('add')">Ajouter un enseignant</button>
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
        <tr v-for="enseignant in enseignants" :key="enseignant.id">
          <td>{{ enseignant.matricule }}</td>
          <td>{{ enseignant.nom }}</td>
          <td>{{ enseignant.prenom }}</td>
          <td>{{ enseignant.specialite }}</td>

          <td class="students">
            <template v-if="enseignant.encadrements.length === 0">
              Aucun étudiant
            </template>
            <template v-else>
              <div v-for="encadrement in enseignant.encadrements" :key="encadrement.id">
                - {{ encadrement.etudiant.nom }} {{ encadrement.etudiant.prenom }} ({{ encadrement.etudiant.matricule }})
              </div>
            </template>
          </td>

          <td>
            <button @click="openModal('edit', enseignant)" class="btn-edit">Modifier</button>
            |
            <button @click="deleteEnseignant(enseignant.id)" class="btn-delete">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal">
        <h2>{{ modalMode === 'add' ? 'Ajouter Enseignant' : 'Modifier Enseignant' }}</h2>
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
            <label>Spécialité</label>
            <input type="text" v-model="form.specialite">
          </div>

          <div class="modal-buttons">
            <button type="submit" class="btn-add">{{ modalMode === 'add' ? 'Ajouter' : 'Mettre à jour' }}</button>
            <button type="button" @click="closeModal" class="btn-cancel">Annuler</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
import { reactive, ref } from 'vue'

export default {
  name: "Enseignants",
  props: {
    enseignants: Array
  },
  setup(props) {
    const showModal = ref(false);
    const modalMode = ref('add');

    const form = reactive({
      id: null,
      matricule: '',
      nom: '',
      prenom: '',
      specialite: ''
    });

    const openModal = (mode, enseignant = null) => {
      modalMode.value = mode;
      if (mode === 'edit' && enseignant) {
        form.id = enseignant.id;
        form.matricule = enseignant.matricule;
        form.nom = enseignant.nom;
        form.prenom = enseignant.prenom;
        form.specialite = enseignant.specialite;
      } else {
        form.id = null;
        form.matricule = '';
        form.nom = '';
        form.prenom = '';
        form.specialite = '';
      }
      showModal.value = true;
    };

    const closeModal = () => {
      showModal.value = false;
    };

    const submitForm = () => {
      if (modalMode.value === 'add') {
        Inertia.post('/enseignants', { ...form });
      } else {
        Inertia.put(`/enseignants/${form.id}`, { ...form });
      }
      closeModal();
    };

    const deleteEnseignant = (id) => {
      if (confirm('Supprimer cet enseignant ?')) {
        Inertia.delete(`/enseignants/${id}`);
      }
    };

    return {
      showModal,
      modalMode,
      form,
      openModal,
      closeModal,
      submitForm,
      deleteEnseignant
    }
  }
}
</script>

<style scoped>
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

.enseignants-page {
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

.enseignants-page h1 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

.add-container {
  text-align: right;
  margin-right: 65px;
  margin-bottom: 20px;
}

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

.students {
  font-size: 14px;
  line-height: 1.4;
}

.btn-edit {
  border: none;
  color: #f39c12;
  text-decoration: none;
  font-weight: bold;
  background-color: transparent;
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
.btn-cancel {
  color: white;
  background: #e74c3c;
  border: none;
  cursor: pointer;
  font-weight: bold;
}

.btn-delete:hover {
  text-decoration: underline;
}

</style>
