

<!-- Student Add Modal -->
<div class="modal-overlay" id="studentModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Dodaj novog učenika</h2>
            <button type="button" class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="studentForm" method="post" action="insert_ucenik.php">
        <div class="modal-body">
                <div class="form-group">
                    <label for="ime">Ime:</label>
                    <input type="text" id="ime" name="ime" required>
                </div>
                <div class="form-group">
                    <label for="prezime">Prezime:</label>
                    <input type="text" id="prezime" name="prezime" required>
                </div>
                <div class="form-group">
                    <label for="razred">Razred:</label>
                    <select id="razred" name="razred" required>
                        <option value="">Izaberite razred</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="odeljenje">Odeljenje:</label>
                    <select id="odeljenje" name="odeljenje" required>
                        <option value="">Izaberite odeljenje</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="login_ucenik">Korisničko ime:</label>
                    <input type="text" id="login_ucenik" name="login" required>
                </div>
                <div class="form-group">
                    <label for="password_ucenik">Lozinka:</label>
                    <input type="password" id="password_ucenik" name="password" required>
                </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal()">Otkaži</button>
            <input type="submit" class="btn-primary" name="dodaj_ucenika" value="DODAJ">
        </div>
        </form>
    </div>
</div>

<!-- Student Edit Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Izmeni učenika</h2>
            <button type="button" class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" method="post" action="update_ucenik.php">
        <div class="modal-body">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-group">
                <label for="edit_ime">Ime:</label>
                <input type="text" id="edit_ime" name="ime" required>
            </div>
            <div class="form-group">
                <label for="edit_prezime">Prezime:</label>
                <input type="text" id="edit_prezime" name="prezime" required>
            </div>
            <div class="form-group">
                <label for="edit_razred">Razred:</label>
                <select id="edit_razred" name="razred" required>
                    <option value="">Izaberite razred</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_odeljenje">Odeljenje:</label>
                <select id="edit_odeljenje" name="odeljenje" required>
                    <option value="">Izaberite odeljenje</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_login">Korisničko ime:</label>
                <input type="text" id="edit_login" name="login" required>
            </div>
            <div class="form-group">
                <label for="edit_password">Nova lozinka:</label>
                <input type="password" id="edit_password" name="password" placeholder="Ostavi prazno za nepromenjenu lozinku">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeEditModal()">Otkaži</button>
            <input type="submit" class="btn-primary" name="update_ucenik" value="SAČUVAJ">
        </div>
        </form>
    </div>
</div>

<!-- Student Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Obriši učenika</h2>
            <button type="button" class="close-btn" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Da li ste sigurni da želite da obrišete ovog učenika?</p>
            <form id="deleteForm" method="post" action="delete_ucenik.php">
                <input type="hidden" id="delete_id" name="id">
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Otkaži</button>
                    <input type="submit" class="btn-danger" name="delete_ucenik" value="OBRIŠI">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Student Modal Functions
    function openModal() {
        document.getElementById('studentModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('studentModal').style.display = 'none';
        document.getElementById('studentForm').reset();
    }

    function openEditModal(id) {
        // Fetch student data
        fetch('get_student.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_ime').value = data.ime;
                document.getElementById('edit_prezime').value = data.prezime;
                document.getElementById('edit_razred').value = data.razred;
                document.getElementById('edit_odeljenje').value = data.odeljenje;
                document.getElementById('edit_login').value = data.login || '';
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('editForm').reset();
    }

    function confirmDelete(id) {
        document.getElementById('delete_id').value = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        document.getElementById('deleteForm').reset();
    }
    
    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modals = document.getElementsByClassName('modal-overlay');
        for (let i = 0; i < modals.length; i++) {
            if (event.target === modals[i]) {
                modals[i].style.display = 'none';
            }
        }
    }
</script>
