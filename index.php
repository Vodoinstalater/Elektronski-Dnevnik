       <?php include 'header.php' ?>
       <?php include 'dbcon.php' ?>
       
       <!-- Message Container -->
       <div id="messageContainer" style="display: none; max-width: 800px; margin: 0 auto 20px; padding: 15px; border-radius: 8px; text-align: center; font-weight: 500; animation: slideDown 0.5s ease-out;">
           <span id="messageText"></span>
           <button onclick="this.parentElement.style.display='none'" style="background: none; border: none; float: right; cursor: pointer; font-size: 1.2em; color: #666;">&times;</button>
       </div>
       
       <style>
           @keyframes slideDown {
               from { opacity: 0; transform: translateY(-20px); }
               to { opacity: 1; transform: translateY(0); }
           }
           
           .message-success {
               background-color: #d4edda;
               color: #155724;
               border-left: 4px solid #28a745;
           }
           
           .message-error {
               background-color: #f8d7da;
               color: #721c24;
               border-left: 4px solid #dc3545;
           }
           
           .admin-header .login-link {
               position: absolute;
               top: 20px;
               right: 20px;
           }
           
           .admin-header .login-link a {
               color: white;
               text-decoration: none;
               font-weight: 500;
               transition: all 0.3s ease;
               padding: 8px 20px;
               background: rgba(255, 255, 255, 0.2);
               border-radius: 20px;
               border: 1px solid rgba(255, 255, 255, 0.3);
           }
           
           .admin-header .login-link a:hover {
               background: rgba(255, 255, 255, 0.3);
               transform: translateY(-2px);
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
           }

           .admin-header {
               position: relative;
               background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
               color: white;
               padding: 30px 20px;
               text-align: center;
               margin-bottom: 30px;
               border-radius: 10px;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           }
               background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
               color: white;
               padding: 30px 20px;
               text-align: center;
               margin-bottom: 30px;
               border-radius: 10px;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           }
           
           .admin-header h1 {
               margin: 0;
               font-size: 2.5em;
               font-weight: 700;
           }
           
           .admin-header p {
               margin: 10px 0 0;
               font-size: 1.1em;
               opacity: 0.9;
           }
           
           .admin-container {
               background: white;
               border-radius: 10px;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
               padding: 25px;
               margin-bottom: 30px;
               max-width: 1200px;
               margin-left: auto;
               margin-right: auto;
           }
           
           .section-header {
               display: flex;
               justify-content: space-between;
               align-items: center;
               margin-bottom: 20px;
               border-bottom: 2px solid #e8ecf0;
               padding-bottom: 15px;
           }
           
           .section-header h2 {
               margin: 0;
               color: #2c3e50;
               font-size: 1.5em;
               font-weight: 600;
           }
           
           table {
               width: 100%;
               border-collapse: collapse;
               margin-bottom: 20px;
               box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
           }
           
           table th {
               background-color: #f8f9fa;
               color: #2c3e50;
               font-weight: 600;
               text-align: left;
               padding: 12px 15px;
               border-bottom: 2px solid #e8ecf0;
           }
           
           table td {
               padding: 10px 15px;
               border-bottom: 1px solid #e8ecf0;
           }
           
           table tr:hover {
               background-color: rgba(102, 126, 234, 0.05);
           }
           
           .btn {
               border: none;
               border-radius: 5px;
               padding: 8px 15px;
               cursor: pointer;
               transition: all 0.3s ease;
               font-weight: 500;
           }
           
           .btn-primary {
               background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
               color: white;
           }
           
           .btn-primary:hover {
               opacity: 0.9;
               transform: translateY(-2px);
           }
           
           .btn-danger {
               background: linear-gradient(135deg, #ff9a9e 0%, #f14667 100%);
               color: white;
           }
           
           .btn-danger:hover {
               opacity: 0.9;
               transform: translateY(-2px);
           }
           
           .btn-sm {
               padding: 5px 10px;
               font-size: 0.9em;
           }
       </style>

       <div class="admin-header">
           <div class="login-link">
               <a href="login.php">
                   <i class="fas fa-sign-in-alt"></i> Login Page
               </a>
           </div>
           <h1>Školska Uprava</h1>
           <p>Administrativni panel za upravljanje učenicima i profesorima</p>
       </div>

       <div class="admin-container">
           <div class="section-header">
               <h2>Lista svih učenika</h2>
               <button type="button" class="btn btn-primary" onclick="openModal()">Dodaj učenika</button>
           </div>

       <div class="tabela"></div>  
       
       <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Razred</th>
                </tr>
            </thead>

            <tbody>
        <?php
                $query='select * from `ucenik`';
                $result=mysqli_query($connection,$query);
                
                if (!$result){
                    die("query Failed".mysqli_error($connection));
                } else{

                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['ime'];?></td>
                        <td><?php echo $row['prezime'];?></td>
                        <td> <?php echo $row['razred'].'-'.$row['odeljenje']; ?> </td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $row['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                        <?php
                    }
                }
                        ?>

            </tbody>
        </table>
        </div>

        <script>
            // Display message from URL parameters
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const message = urlParams.get('message');
                const messageType = urlParams.get('type') || 'success';
                
                if (message) {
                    const container = document.getElementById('messageContainer');
                    const messageText = document.getElementById('messageText');
                    
                    container.className = ''; // Reset classes
                    container.classList.add('message-' + messageType);
                    messageText.textContent = message;
                    container.style.display = 'block';
                    
                    // Auto-hide after 5 seconds
                    setTimeout(() => {
                        container.style.opacity = '0';
                        setTimeout(() => {
                            container.style.display = 'none';
                        }, 500);
                    }, 5000);
                }
            });
        </script>

        <!-- Modal -->
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
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Otkaži</button>
                    <input type="submit" class="btn-primary" name="dodaj_ucenika" value="DODAJ">
                </div>
                </form>
            </div>
        </div>

        <script>
            function openModal() {
                document.getElementById('studentModal').style.display = 'flex';
            }

            function closeModal() {
                document.getElementById('studentModal').style.display = 'none';
                document.getElementById('studentForm').reset();
            }

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                const modal = document.getElementById('studentModal');
                if (event.target === modal) {
                    closeModal();
                }
            }
        </script>

        <!-- Edit Modal -->
        <div class="modal-overlay" id="editModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Edit Student</h2>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <input type="submit" class="btn-primary" name="update_ucenik" value="Update">
                </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal-overlay" id="deleteModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Delete Student</h2>
                    <button type="button" class="close-btn" onclick="closeDeleteModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student?</p>
                    <form id="deleteForm" method="post" action="delete_ucenik.php">
                        <input type="hidden" id="delete_id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                            <input type="submit" class="btn-danger" name="delete_ucenik" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
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
        </script>

        </div> <!-- Close the previous section -->

        <!-- Professors Section -->
        <div class="admin-container">
            <div class="section-header">
                <h2>Lista svih profesora</h2>
                <button type="button" class="btn btn-primary" onclick="openProfesorModal()">Dodaj profesora</button>
            </div>

        <div class="tabela"></div>  
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $query='select * from `profesor`';
                $result=mysqli_query($connection,$query);
                
                if (!$result){
                    die("query Failed".mysqli_error($connection));
                } else{

                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['ime'];?></td>
                        <td><?php echo $row['prezime'];?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditProfesorModal(<?php echo $row['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteProfesor(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                        <?php
                    }
                }
                        ?>

            </tbody>
        </table>
        </div>

        <!-- Professor Add Modal -->
        <div class="modal-overlay" id="profesorModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Dodaj novog profesora</h2>
                    <button type="button" class="close-btn" onclick="closeProfesorModal()">&times;</button>
                </div>
                <form id="profesorForm" method="post" action="insert_profesor.php">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="ime_profesor">Ime:</label>
                            <input type="text" id="ime_profesor" name="ime" required>
                        </div>
                        <div class="form-group">
                            <label for="prezime_profesor">Prezime:</label>
                            <input type="text" id="prezime_profesor" name="prezime" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeProfesorModal()">Otkaži</button>
                    <input type="submit" class="btn-primary" name="dodaj_profesora" value="DODAJ">
                </div>
                </form>
            </div>
        </div>

        <!-- Professor Edit Modal -->
        <div class="modal-overlay" id="editProfesorModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Edit Professor</h2>
                    <button type="button" class="close-btn" onclick="closeEditProfesorModal()">&times;</button>
                </div>
                <form id="editProfesorForm" method="post" action="update_profesor.php">
                <div class="modal-body">
                    <input type="hidden" id="edit_profesor_id" name="id">
                    <div class="form-group">
                        <label for="edit_profesor_ime">Ime:</label>
                        <input type="text" id="edit_profesor_ime" name="ime" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_profesor_prezime">Prezime:</label>
                        <input type="text" id="edit_profesor_prezime" name="prezime" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeEditProfesorModal()">Cancel</button>
                    <input type="submit" class="btn-primary" name="update_profesor" value="Update">
                </div>
                </form>
            </div>
        </div>

        <!-- Professor Delete Confirmation Modal -->
        <div class="modal-overlay" id="deleteProfesorModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Delete Professor</h2>
                    <button type="button" class="close-btn" onclick="closeDeleteProfesorModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this professor?</p>
                    <form id="deleteProfesorForm" method="post" action="delete_profesor.php">
                        <input type="hidden" id="delete_profesor_id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeDeleteProfesorModal()">Cancel</button>
                            <input type="submit" class="btn-danger" name="delete_profesor" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Professor Modal Functions
            function openProfesorModal() {
                document.getElementById('profesorModal').style.display = 'flex';
            }

            function closeProfesorModal() {
                document.getElementById('profesorModal').style.display = 'none';
                document.getElementById('profesorForm').reset();
            }

            function openEditProfesorModal(id) {
                // Fetch professor data
                fetch('get_profesor.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_profesor_id').value = data.id;
                        document.getElementById('edit_profesor_ime').value = data.ime;
                        document.getElementById('edit_profesor_prezime').value = data.prezime;
                        document.getElementById('editProfesorModal').style.display = 'flex';
                    });
            }

            function closeEditProfesorModal() {
                document.getElementById('editProfesorModal').style.display = 'none';
                document.getElementById('editProfesorForm').reset();
            }

            function confirmDeleteProfesor(id) {
                document.getElementById('delete_profesor_id').value = id;
                document.getElementById('deleteProfesorModal').style.display = 'flex';
            }

            function closeDeleteProfesorModal() {
                document.getElementById('deleteProfesorModal').style.display = 'none';
                document.getElementById('deleteProfesorForm').reset();
            }
        </script>

        <!-- Subjects Section -->
        <div class="admin-container">
            <div class="section-header">
                <h2>Lista svih predmeta</h2>
                <button type="button" class="btn btn-primary" onclick="openPredmetModal()">Dodaj predmet</button>
            </div>

        <div class="tabela"></div>  
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Razred</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $query='select * from `predmet`';
                $result=mysqli_query($connection,$query);
                
                if (!$result){
                    die("query Failed".mysqli_error($connection));
                } else{

                    while($row=mysqli_fetch_assoc($result)){
                        ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['naziv'];?></td>
                        <td><?php echo $row['razred'];?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openEditPredmetModal(<?php echo $row['id']; ?>)">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeletePredmet(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                        <?php
                    }
                }
                        ?>

            </tbody>
        </table>
        </div>

        <!-- Subject Add Modal -->
        <div class="modal-overlay" id="predmetModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Dodaj novi predmet</h2>
                    <button type="button" class="close-btn" onclick="closePredmetModal()">&times;</button>
                </div>
                <form id="predmetForm" method="post" action="insert_predmet.php">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="naziv_predmet">Naziv:</label>
                            <input type="text" id="naziv_predmet" name="naziv" required>
                        </div>
                        <div class="form-group">
                            <label for="razred_predmet">Razred:</label>
                            <select id="razred_predmet" name="razred" required>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closePredmetModal()">Otkaži</button>
                    <input type="submit" class="btn-primary" name="dodaj_predmet" value="DODAJ">
                </div>
                </form>
            </div>
        </div>

        <!-- Subject Edit Modal -->
        <div class="modal-overlay" id="editPredmetModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Edit Subject</h2>
                    <button type="button" class="close-btn" onclick="closeEditPredmetModal()">&times;</button>
                </div>
                <form id="editPredmetForm" method="post" action="update_predmet.php">
                <div class="modal-body">
                    <input type="hidden" id="edit_predmet_id" name="id">
                    <div class="form-group">
                        <label for="edit_predmet_naziv">Naziv:</label>
                        <input type="text" id="edit_predmet_naziv" name="naziv" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_predmet_razred">Razred:</label>
                        <select id="edit_predmet_razred" name="razred" required>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeEditPredmetModal()">Cancel</button>
                    <input type="submit" class="btn-primary" name="update_predmet" value="Update">
                </div>
                </form>
            </div>
        </div>

        <!-- Subject Delete Confirmation Modal -->
        <div class="modal-overlay" id="deletePredmetModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Delete Subject</h2>
                    <button type="button" class="close-btn" onclick="closeDeletePredmetModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this subject?</p>
                    <form id="deletePredmetForm" method="post" action="delete_predmet.php">
                        <input type="hidden" id="delete_predmet_id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeDeletePredmetModal()">Cancel</button>
                            <input type="submit" class="btn-danger" name="delete_predmet" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Subject Modal Functions
            function openPredmetModal() {
                document.getElementById('predmetModal').style.display = 'flex';
            }

            function closePredmetModal() {
                document.getElementById('predmetModal').style.display = 'none';
                document.getElementById('predmetForm').reset();
            }

            function openEditPredmetModal(id) {
                // Fetch subject data
                fetch('get_predmet.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_predmet_id').value = data.id;
                        document.getElementById('edit_predmet_naziv').value = data.naziv;
                        document.getElementById('edit_predmet_razred').value = data.razred;
                        document.getElementById('editPredmetModal').style.display = 'flex';
                    });
            }

            function closeEditPredmetModal() {
                document.getElementById('editPredmetModal').style.display = 'none';
                document.getElementById('editPredmetForm').reset();
            }

            function confirmDeletePredmet(id) {
                document.getElementById('delete_predmet_id').value = id;
                document.getElementById('deletePredmetModal').style.display = 'flex';
            }

            function closeDeletePredmetModal() {
                document.getElementById('deletePredmetModal').style.display = 'none';
                document.getElementById('deletePredmetForm').reset();
            }
        </script>

        <!-- Professor-Subject Relationship Section -->
        <div class="admin-container">
            <div class="section-header">
                <h2>Dodela predmeta profesorima</h2>
                <button type="button" class="btn btn-primary" onclick="openDrziModal()">Dodaj vezu</button>
            </div>

        <div class="tabela"></div>  
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profesor</th>
                    <th>Predmet</th>
                    <th>Razred</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $query = 'SELECT d.id, p.ime, p.prezime, pr.naziv, pr.razred 
                          FROM drzi d 
                          JOIN profesor p ON d.profesor_id = p.id 
                          JOIN predmet pr ON d.predmet_id = pr.id 
                          ORDER BY p.prezime, p.ime, pr.razred, pr.naziv';
                $result = mysqli_query($connection, $query);
                
                if (!$result){
                    die("query Failed".mysqli_error($connection));
                } else{
                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['prezime'] . ' ' . $row['ime'];?></td>
                        <td><?php echo $row['naziv'];?></td>
                        <td><?php echo $row['razred'];?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteDrzi(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        </div>

        <!-- Add Professor-Subject Relationship Modal -->
        <div class="modal-overlay" id="drziModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Dodeli predmet profesoru</h2>
                    <button type="button" class="close-btn" onclick="closeDrziModal()">&times;</button>
                </div>
                <form id="drziForm" method="post" action="insert_drzi.php">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="profesor_id">Profesor:</label>
                        <select id="profesor_id" name="profesor_id" required>
                            <option value="">Izaberite profesora</option>
                            <?php
                            $query = 'SELECT id, ime, prezime FROM profesor ORDER BY prezime, ime';
                            $result = mysqli_query($connection, $query);
                            
                            if ($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value=\"" . $row['id'] . "\">" . $row['prezime'] . " " . $row['ime'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="predmet_id">Predmet:</label>
                        <select id="predmet_id" name="predmet_id" required>
                            <option value="">Izaberite predmet</option>
                            <?php
                            $query = 'SELECT id, naziv, razred FROM predmet ORDER BY razred, naziv';
                            $result = mysqli_query($connection, $query);
                            
                            if ($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value=\"" . $row['id'] . "\">" . $row['naziv'] . " (" . $row['razred'] . ". razred)</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeDrziModal()">Otkaži</button>
                    <input type="submit" class="btn-primary" name="dodaj_drzi" value="DODAJ">
                </div>
                </form>
            </div>
        </div>

        <!-- Delete Professor-Subject Relationship Confirmation Modal -->
        <div class="modal-overlay" id="deleteDrziModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Obriši vezu</h2>
                    <button type="button" class="close-btn" onclick="closeDeleteDrziModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Da li ste sigurni da želite da obrišete ovu vezu?</p>
                    <form id="deleteDrziForm" method="post" action="delete_drzi.php">
                        <input type="hidden" id="delete_drzi_id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeDeleteDrziModal()">Otkaži</button>
                            <input type="submit" class="btn-danger" name="delete_drzi" value="Obriši">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Professor-Subject Relationship Modal Functions
            function openDrziModal() {
                document.getElementById('drziModal').style.display = 'flex';
            }

            function closeDrziModal() {
                document.getElementById('drziModal').style.display = 'none';
                document.getElementById('drziForm').reset();
            }

            function confirmDeleteDrzi(id) {
                document.getElementById('delete_drzi_id').value = id;
                document.getElementById('deleteDrziModal').style.display = 'flex';
            }

            function closeDeleteDrziModal() {
                document.getElementById('deleteDrziModal').style.display = 'none';
                document.getElementById('deleteDrziForm').reset();
            }
        </script>

        <!-- Grades Section -->
        <div class="admin-container">
            <div class="section-header">
                <h2>Pregled svih ocena</h2>
            </div>

        <div class="tabela"></div>  
       
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Učenik</th>
                    <th>Razred</th>
                    <th>Predmet</th>
                    <th>Ocena</th>
                    <th>Datum</th>
                    <th>Profesor</th>
                    <th>Komentar</th>
                    <th>Akcije</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $query = 'SELECT o.*, 
                          u.ime as ucenik_ime, u.prezime as ucenik_prezime, u.razred, u.odeljenje, 
                          p.naziv as predmet_naziv, 
                          pr.ime as profesor_ime, pr.prezime as profesor_prezime 
                          FROM ocena o 
                          JOIN ucenik u ON o.ucenik_id = u.id 
                          JOIN predmet p ON o.predmet_id = p.id 
                          JOIN profesor pr ON o.profesor_id = pr.id 
                          ORDER BY o.datum DESC';
                $result = mysqli_query($connection, $query);
                
                if (!$result){
                    die("query Failed".mysqli_error($connection));
                } else{
                    while($row = mysqli_fetch_assoc($result)){
                        $date = date('d.m.Y', strtotime($row['datum']));
                        ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['ucenik_prezime'] . ' ' . $row['ucenik_ime'];?></td>
                        <td><?php echo $row['razred'] . '-' . $row['odeljenje'];?></td>
                        <td><?php echo $row['predmet_naziv'];?></td>
                        <td><strong><?php echo $row['vrednost'];?></strong></td>
                        <td><?php echo $date;?></td>
                        <td><?php echo $row['profesor_prezime'] . ' ' . $row['profesor_ime'];?></td>
                        <td><?php echo $row['komentar'] ? $row['komentar'] : '-';?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteOcena(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        </div>

        <!-- Delete Grade Confirmation Modal -->
        <div class="modal-overlay" id="deleteOcenaModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h2>Obriši ocenu</h2>
                    <button type="button" class="close-btn" onclick="closeDeleteOcenaModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Da li ste sigurni da želite da obrišete ovu ocenu?</p>
                    <form id="deleteOcenaForm" method="post" action="delete_ocena.php">
                        <input type="hidden" id="delete_ocena_id" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn-secondary" onclick="closeDeleteOcenaModal()">Otkaži</button>
                            <input type="submit" class="btn-danger" name="delete_ocena" value="Obriši">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Grade delete modal functions
            function confirmDeleteOcena(id) {
                document.getElementById('delete_ocena_id').value = id;
                document.getElementById('deleteOcenaModal').style.display = 'flex';
            }

            function closeDeleteOcenaModal() {
                document.getElementById('deleteOcenaModal').style.display = 'none';
                document.getElementById('deleteOcenaForm').reset();
            }
        </script>

        </body>

            <?php include 'footer.php' ?>
