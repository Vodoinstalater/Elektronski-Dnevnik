<!-- Grade Modal -->
<div class="modal-overlay" id="gradeModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Dodaj ocenu</h2>
            <button type="button" class="close-btn" onclick="closeGradeModal()">&times;</button>
        </div>
        <form id="gradeForm" method="post" action="insert_ocena.php">
        <div class="modal-body">
            <input type="hidden" id="student_id" name="ucenik_id">
            <input type="hidden" id="profesor_id" name="profesor_id" value="<?php echo $_SESSION['user_id']; ?>">
            
            <div class="form-group">
                <label for="student_name">Učenik:</label>
                <input type="text" id="student_name" readonly>
            </div>
            
            <div class="form-group">
                <label for="predmet_id">Predmet:</label>
                <select id="predmet_id" name="predmet_id" required>
                    <option value="">Izaberite predmet</option>
                    <?php
                    $profesor_id = $_SESSION['user_id'];
                    $query = 'SELECT p.id, p.naziv, p.razred 
                              FROM drzi d 
                              JOIN predmet p ON d.predmet_id = p.id 
                              WHERE d.profesor_id = ? 
                              ORDER BY p.razred, p.naziv';
                    
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "i", $profesor_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"" . $row['id'] . "\" data-razred=\"" . $row['razred'] . "\">" . $row['naziv'] . " (" . $row['razred'] . ". razred)</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="vrednost">Ocena:</label>
                <select id="vrednost" name="vrednost" required>
                    <option value="">Izaberite ocenu</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="datum">Datum:</label>
                <input type="date" id="datum" name="datum" required value="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label for="komentar">Komentar:</label>
                <textarea id="komentar" name="komentar" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeGradeModal()">Otkaži</button>
            <input type="submit" class="btn-primary" name="dodaj_ocenu" value="Dodaj ocenu">
        </div>
        </form>
    </div>
</div>

<script>
    // Student grade modal functions
    function openGradeModal(studentId, studentName, studentRazred) {
        document.getElementById('student_id').value = studentId;
        document.getElementById('student_name').value = studentName;
        
        // Filter subject options based on student's grade level
        const predmetSelect = document.getElementById('predmet_id');
        const options = predmetSelect.options;
        
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            if (option.value === '') continue; // Skip the placeholder option
            
            const subjectRazred = option.getAttribute('data-razred');
            if (subjectRazred == studentRazred) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
        
        document.getElementById('gradeModal').style.display = 'flex';
    }

    function closeGradeModal() {
        document.getElementById('gradeModal').style.display = 'none';
        document.getElementById('gradeForm').reset();
    }
</script>
