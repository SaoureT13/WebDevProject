<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Nouvelle demande</h2>
        <form
            hx-post="/student/request"
            hx-target="#demandes"
            hx-swap="beforeend">
            @csrf
            <div class="input-box">
                <label for="theme">Theme:</label><br>
                <input type="text" id="theme" name="theme" value="{{ old('theme') }}"><br>
            </div>
            @error('theme')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="memory_problems">Problématique:</label><br>
                <input type="text" id="memory_problems" name="memory_problems" value="{{ old('memory_problems') }}"><br>
            </div>
            @error('memory_problems')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="global_objective">Objectif global:</label><br>
                <input type="text" id="global_objective" name="global_objective"
                       value="{{ old('global_objective') }}"><br>
            </div>
            @error('global_objective')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="specific_objective">Objectif spécifique:</label><br>
                <input type="text" id="specific_objective" name="specific_objective"
                       value="{{ old('specific_objective') }}"><br>
            </div>
            @error('specific_objective')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div class="input-box">
                <label for="expected_result">Résultat attendu:</label><br>
                <input type="text" id="expected_result" name="expected_result" value="{{ old('expected_result') }}"><br>
            </div>
            @error('expected_result')
            <span class="alert">Ce champs est obligatoire</span>
            @enderror
            <div style="display: flex; width: 100%; justify-content: space-between">
                <div class="input-box" style="width: 45%">
                    <label for="company_name">Société:</label><br>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                           placeholder="Nom de la société"><br>
                </div>
                <div class="input-box" style="width: 45%">
                    <label for="company_contact">Contact société:</label><br>
                    <input type="text" id="company_contact" name="company_contact" value="{{ old('company_contact') }}"
                           placeholder="Contact de la société"><br>
                </div>
            </div>

            <button type="submit" class="btn-submit">Soumettre</button>
        </form>
    </div>
</div>
