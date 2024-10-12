@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Create Image</h2>

    <div class="d-flex justify-content-between mb-3">
        <button id="saveImage" class="btn btn-success">Save Image</button>
        <button id="resetCanvas" class="btn btn-warning">Reset Canvas</button>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="bg-light p-4 border rounded shadow">
                <h5 class="mb-3">Tools</h5>

                <div class="mb-3">
                    <label for="widthInput" class="form-label">Image Width:</label>
                    <input type="number" id="widthInput" class="form-control" placeholder="Width" value="500" />
                </div>

                <div class="mb-3">
                    <label for="heightInput" class="form-label">Image Height:</label>
                    <input type="number" id="heightInput" class="form-control" placeholder="Height" value="300" />
                </div>

                <div class="mb-3">
                    <label for="textInput" class="form-label">Add Text:</label>
                    <input type="text" id="textInput" class="form-control" placeholder="Enter your text here" />
                    <button id="addText" class="btn btn-primary mt-2">Add Text</button>
                    <button id="deleteText" class="btn btn-danger mt-2">Delete Selected Text</button>
                </div>

                <div class="mb-3">
                    <label for="fontSelect" class="form-label">Select Font:</label>
                    <select id="fontSelect" class="form-select">
                        <option value="Arial" style="font-family: Arial;">Arial (Aa Bb Cc)</option>
                        <option value="Verdana" style="font-family: Verdana;">Verdana (Aa Bb Cc)</option>
                        <option value="Courier New" style="font-family: 'Courier New';">Courier New (Aa Bb Cc)</option>
                        <option value="Georgia" style="font-family: Georgia;">Georgia (Aa Bb Cc)</option>
                        <option value="Times New Roman" style="font-family: 'Times New Roman';">Times New Roman (Aa Bb Cc)</option>
                        <option value="Trebuchet MS" style="font-family: 'Trebuchet MS';">Trebuchet MS (Aa Bb Cc)</option>
                        <option value="Tahoma" style="font-family: Tahoma;">Tahoma (Aa Bb Cc)</option>
                        <option value="Impact" style="font-family: Impact;">Impact (Aa Bb Cc)</option>
                        <option value="Comic Sans MS" style="font-family: 'Comic Sans MS';">Comic Sans MS (Aa Bb Cc)</option>
                        <option value="Open Sans" style="font-family: 'Open Sans';">Open Sans (Aa Bb Cc)</option>
                        <option value="Roboto" style="font-family: Roboto;">Roboto (Aa Bb Cc)</option>
                        <option value="Lato" style="font-family: Lato;">Lato (Aa Bb Cc)</option>
                        <option value="Montserrat" style="font-family: Montserrat;">Montserrat (Aa Bb Cc)</option>
                        <option value="Raleway" style="font-family: Raleway;">Raleway (Aa Bb Cc)</option>
                        <option value="Poppins" style="font-family: Poppins;">Poppins (Aa Bb Cc)</option>
                        <option value="Dancing Script" style="font-family: 'Dancing Script';">Dancing Script (Aa Bb Cc)</option>
                        <option value="Merriweather" style="font-family: Merriweather;">Merriweather (Aa Bb Cc)</option>
                        <option value="Oswald" style="font-family: Oswald;">Oswald (Aa Bb Cc)</option>
                        <option value="Nunito" style="font-family: Nunito;">Nunito (Aa Bb Cc)</option>
                        <option value="Ubuntu" style="font-family: Ubuntu;">Ubuntu (Aa Bb Cc)</option>
                        <option value="PT Sans" style="font-family: 'PT Sans';">PT Sans (Aa Bb Cc)</option>
                        <option value="Source Sans Pro" style="font-family: 'Source Sans Pro';">Source Sans Pro (Aa Bb Cc)</option>
                        <option value="Barlow" style="font-family: Barlow;">Barlow (Aa Bb Cc)</option>
                        <option value="Cabin" style="font-family: Cabin;">Cabin (Aa Bb Cc)</option>
                        <option value="Cairo" style="font-family: Cairo;">Cairo (Aa Bb Cc)</option>
                        <option value="Creepster" style="font-family: Creepster;">Creepster (Aa Bb Cc)</option>
                        <option value="Exo" style="font-family: Exo;">Exo (Aa Bb Cc)</option>
                        <option value="Fjalla One" style="font-family: 'Fjalla One';">Fjalla One (Aa Bb Cc)</option>
                        <option value="Fredericka the Great" style="font-family: 'Fredericka the Great';">Fredericka the Great (Aa Bb Cc)</option>
                        <option value="Hind" style="font-family: Hind;">Hind (Aa Bb Cc)</option>
                        <option value="Julius Sans One" style="font-family: 'Julius Sans One';">Julius Sans One (Aa Bb Cc)</option>
                        <option value="Lobster" style="font-family: Lobster;">Lobster (Aa Bb Cc)</option>
                        <option value="Muli" style="font-family: Muli;">Muli (Aa Bb Cc)</option>
                        <option value="Noto Sans" style="font-family: 'Noto Sans';">Noto Sans (Aa Bb Cc)</option>
                        <option value="Quicksand" style="font-family: Quicksand;">Quicksand (Aa Bb Cc)</option>
                        <option value="Raleway Dots" style="font-family: 'Raleway Dots';">Raleway Dots (Aa Bb Cc)</option>
                        <option value="Sacramento" style="font-family: Sacramento;">Sacramento (Aa Bb Cc)</option>
                        <option value="Satisfy" style="font-family: Satisfy;">Satisfy (Aa Bb Cc)</option>
                        <option value="Ubuntu Condensed" style="font-family: 'Ubuntu Condensed';">Ubuntu Condensed (Aa Bb Cc)</option>
                        <option value="Varela Round" style="font-family: 'Varela Round';">Varela Round (Aa Bb Cc)</option>
                        <option value="Zilla Slab" style="font-family: 'Zilla Slab';">Zilla Slab (Aa Bb Cc)</option>
                        <option value="Abril Fatface" style="font-family: 'Abril Fatface';">Abril Fatface (Aa Bb Cc)</option>
                        <option value="Akronim" style="font-family: Akronim;">Akronim (Aa Bb Cc)</option>
                        <option value="Alfa Slab One" style="font-family: 'Alfa Slab One';">Alfa Slab One (Aa Bb Cc)</option>
                        <option value="Antic Slab" style="font-family: 'Antic Slab';">Antic Slab (Aa Bb Cc)</option>
                        <option value="Arvo" style="font-family: Arvo;">Arvo (Aa Bb Cc)</option>
                        <option value="Bungee" style="font-family: Bungee;">Bungee (Aa Bb Cc)</option>
                        <option value="Cardo" style="font-family: Cardo;">Cardo (Aa Bb Cc)</option>
                        <option value="Droid Sans" style="font-family: 'Droid Sans';">Droid Sans (Aa Bb Cc)</option>
                        <option value="Fauna One" style="font-family: Fauna One;">Fauna One (Aa Bb Cc)</option>
                        <option value="Gloock" style="font-family: Gloock;">Gloock (Aa Bb Cc)</option>
                        <option value="Hammersmith One" style="font-family: 'Hammersmith One';">Hammersmith One (Aa Bb Cc)</option>
                        <option value="Indie Flower" style="font-family: 'Indie Flower';">Indie Flower (Aa Bb Cc)</option>
                        <option value="Just Me Again Down Here" style="font-family: 'Just Me Again Down Here';">Just Me Again Down Here (Aa Bb Cc)</option>
                        <option value="Kalam" style="font-family: Kalam;">Kalam (Aa Bb Cc)</option>
                        <option value="Laila" style="font-family: Laila;">Laila (Aa Bb Cc)</option>
                        <option value="Monoton" style="font-family: Monoton;">Monoton (Aa Bb Cc)</option>
                        <option value="Neuton" style="font-family: Neuton;">Neuton (Aa Bb Cc)</option>
                        <option value="Oxygen" style="font-family: Oxygen;">Oxygen (Aa Bb Cc)</option>
                        <option value="Racing Sans One" style="font-family: 'Racing Sans One';">Racing Sans One (Aa Bb Cc)</option>
                        <option value="Salsa" style="font-family: Salsa;">Salsa (Aa Bb Cc)</option>
                        <option value="Slabo 27px" style="font-family: 'Slabo 27px';">Slabo 27px (Aa Bb Cc)</option>
                        <option value="Stardos Stencil" style="font-family: 'Stardos Stencil';">Stardos Stencil (Aa Bb Cc)</option>
                        <option value="Vampiro One" style="font-family: 'Vampiro One';">Vampiro One (Aa Bb Cc)</option>
                        <option value="Zeyada" style="font-family: Zeyada;">Zeyada (Aa Bb Cc)</option>
                        <option value="Alegreya" style="font-family: Alegreya;">Alegreya (Aa Bb Cc)</option>
                        <option value="Bitter" style="font-family: Bitter;">Bitter (Aa Bb Cc)</option>
                        <option value="Black Han Sans" style="font-family: 'Black Han Sans';">Black Han Sans (Aa Bb Cc)</option>
                        <option value="Cinzel" style="font-family: Cinzel;">Cinzel (Aa Bb Cc)</option>
                        <option value="Dancing Script" style="font-family: 'Dancing Script';">Dancing Script (Aa Bb Cc)</option>
                        <option value="Fira Sans" style="font-family: 'Fira Sans';">Fira Sans (Aa Bb Cc)</option>
                        <option value="Great Vibes" style="font-family: 'Great Vibes';">Great Vibes (Aa Bb Cc)</option>
                        <option value="Julius Sans One" style="font-family: 'Julius Sans One';">Julius Sans One (Aa Bb Cc)</option>
                        <option value="Libre Baskerville" style="font-family: 'Libre Baskerville';">Libre Baskerville (Aa Bb Cc)</option>
                        <option value="Noto Serif" style="font-family: 'Noto Serif';">Noto Serif (Aa Bb Cc)</option>
                        <option value="Rokkitt" style="font-family: Rokkitt;">Rokkitt (Aa Bb Cc)</option>
                        <option value="Sarpanch" style="font-family: Sarpanch;">Sarpanch (Aa Bb Cc)</option>
                        <option value="Tinos" style="font-family: Tinos;">Tinos (Aa Bb Cc)</option>
                        <option value="Work Sans" style="font-family: 'Work Sans';">Work Sans (Aa Bb Cc)</option>
                        <option value="Yeseva One" style="font-family: 'Yeseva One';">Yeseva One (Aa Bb Cc)</option>
                        <option value="Zilla Slab Highlight" style="font-family: 'Zilla Slab Highlight';">Zilla Slab Highlight (Aa Bb Cc)</option>
                        <option value="Abril Fatface" style="font-family: 'Abril Fatface';">Abril Fatface (Aa Bb Cc)</option>
                        <option value="Alfa Slab One" style="font-family: 'Alfa Slab One';">Alfa Slab One (Aa Bb Cc)</option>
                        <option value="Antic Slab" style="font-family: 'Antic Slab';">Antic Slab (Aa Bb Cc)</option>
                        <option value="Arvo" style="font-family: Arvo;">Arvo (Aa Bb Cc)</option>
                        <option value="Bungee" style="font-family: Bungee;">Bungee (Aa Bb Cc)</option>
                        <option value="Cardo" style="font-family: Cardo;">Cardo (Aa Bb Cc)</option>
                        <option value="Droid Sans" style="font-family: 'Droid Sans';">Droid Sans (Aa Bb Cc)</option>
                        <option value="Fauna One" style="font-family: Fauna One;">Fauna One (Aa Bb Cc)</option>
                        <option value="Gloock" style="font-family: Gloock;">Gloock (Aa Bb Cc)</option>
                        <option value="Hammersmith One" style="font-family: 'Hammersmith One';">Hammersmith One (Aa Bb Cc)</option>
                        <option value="Indie Flower" style="font-family: 'Indie Flower';">Indie Flower (Aa Bb Cc)</option>
                        <option value="Just Me Again Down Here" style="font-family: 'Just Me Again Down Here';">Just Me Again Down Here (Aa Bb Cc)</option>
                        <option value="Kalam" style="font-family: Kalam;">Kalam (Aa Bb Cc)</option>
                        <option value="Laila" style="font-family: Laila;">Laila (Aa Bb Cc)</option>
                        <option value="Monoton" style="font-family: Monoton;">Monoton (Aa Bb Cc)</option>
                        <option value="Neuton" style="font-family: Neuton;">Neuton (Aa Bb Cc)</option>
                        <option value="Oxygen" style="font-family: Oxygen;">Oxygen (Aa Bb Cc)</option>
                        <option value="Racing Sans One" style="font-family: 'Racing Sans One';">Racing Sans One (Aa Bb Cc)</option>
                        <option value="Salsa" style="font-family: Salsa;">Salsa (Aa Bb Cc)</option>
                        <option value="Slabo 27px" style="font-family: 'Slabo 27px';">Slabo 27px (Aa Bb Cc)</option>
                        <option value="Stardos Stencil" style="font-family: 'Stardos Stencil';">Stardos Stencil (Aa Bb Cc)</option>
                        <option value="Vampiro One" style="font-family: 'Vampiro One';">Vampiro One (Aa Bb Cc)</option>
                        <option value="Zeyada" style="font-family: Zeyada;">Zeyada (Aa Bb Cc)</option>
                    </select>
                </div>
                

                <div class="mb-3">
                    <label for="logoSelect" class="form-label">Select Logo:</label>
                    <select id="logoSelect" class="form-select">
                        <option value="">-- Choose a Logo --</option>
                        @foreach (glob(public_path('logos/*')) as $logo)
                            <option value="{{ asset('logos/' . basename($logo)) }}">{{ basename($logo) }}</option>
                        @endforeach
                    </select>
                    <button id="deleteImage" class="btn btn-danger mt-2">Delete Selected Image</button>
                </div>

                <hr>

                <div class="mb-3">
                    <label for="textColor" class="form-label">Text Color:</label>
                    <input type="color" id="textColor" value="#000000" class="form-control" />
                </div>

                <div class="mb-3">
                    <label for="bgColor" class="form-label">Background Color:</label>
                    <input type="color" id="bgColor" value="#ffffff" class="form-control" />
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="canvas-container" class="mt-4 border rounded shadow">
                <canvas id="imageCanvas" width="1010" height="500"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Custom Save Confirmation Alert -->
<div id="customAlert" class="custom-alert">
    <div class="custom-alert-content">
        <h5>Save Image</h5>
        <label for="alertImageName">Enter a name for your image (without extension):</label>
        <input type="text" id="alertImageName" class="form-control" placeholder="my_image" />
        <div class="d-flex justify-content-end mt-3">
            <button id="confirmAlertSave" class="btn btn-primary me-2">Save</button>
            <button id="cancelAlertSave" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<!-- Custom Alert for General Messages -->
<div id="generalAlert" class="custom-alert">
    <div class="custom-alert-content">
        <h5 id="alertTitle">Alert</h5>
        <p id="alertMessage">Message goes here...</p>
        <div class="d-flex justify-content-end mt-3">
            <button id="confirmGeneralAlert" class="btn btn-primary">OK</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.4/fabric.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = new fabric.Canvas('imageCanvas');
        console.log("Canvas initialized");

        // Set canvas background color
        document.getElementById('bgColor').addEventListener('input', function() {
            canvas.setBackgroundColor(this.value, canvas.renderAll.bind(canvas));
        });

        // Add Text to Canvas
        document.getElementById('addText').addEventListener('click', function() {
            const textInput = document.getElementById('textInput').value;
            if (textInput) {
                let canvasText = new fabric.Text(textInput, {
                    left: 50,
                    top: 50,
                    fontSize: 30,
                    fontFamily: document.getElementById('fontSelect').value,
                    fill: document.getElementById('textColor').value
                });
                canvas.add(canvasText);
                canvas.renderAll();
                document.getElementById('textInput').value = ''; // Clear input after adding
            } else {
                showGeneralAlert("Please enter text before adding.", "Error");
            }
        });

        // Change text color
        document.getElementById('textColor').addEventListener('input', function() {
            let activeObj = canvas.getActiveObject();
            if (activeObj && activeObj.type === 'text') {
                activeObj.set("fill", this.value);
                canvas.renderAll();
            }
        });

        // Change font family of active text object
        document.getElementById('fontSelect').addEventListener('change', function() {
            let activeObj = canvas.getActiveObject();
            if (activeObj && activeObj.type === 'text') {
                activeObj.set("fontFamily", this.value);
                canvas.renderAll();
            }
        });

        // Add selected logo to canvas
        document.getElementById('logoSelect').addEventListener('change', function() {
            const selectedLogo = this.value;
            if (selectedLogo) {
                let imgObj = new Image();
                imgObj.src = selectedLogo;
                imgObj.onload = function () {
                    let image = new fabric.Image(imgObj);
                    image.set({
                        left: 150,
                        top: 150,
                        scaleX: 0.5,
                        scaleY: 0.5
                    });
                    canvas.add(image);
                    canvas.renderAll();
                };
                imgObj.onerror = function() {
                    console.error("Error loading image: ", selectedLogo);
                };
            }
        });

        // Delete selected text from Canvas
        document.getElementById('deleteText').addEventListener('click', function() {
            let activeObj = canvas.getActiveObject();
            if (activeObj && activeObj.type === 'text') {
                canvas.remove(activeObj);
                canvas.renderAll();
            } else {
                showGeneralAlert("Please select a text object to delete.", "Error");
            }
        });

        // Open custom alert for saving
        document.getElementById('saveImage').addEventListener('click', function() {
            document.getElementById('customAlert').style.display = 'flex';
        });

        // Handle Save Button inside Custom Alert
        document.getElementById('confirmAlertSave').addEventListener('click', function() {
            const filename = document.getElementById('alertImageName').value || 'my_image';

            // Get the specified width and height from inputs
            const width = parseInt(document.getElementById('widthInput').value) || 500;
            const height = parseInt(document.getElementById('heightInput').value) || 300;

            // Set canvas dimensions without clearing objects
            canvas.setWidth(width);
            canvas.setHeight(height);

            const imageData = canvas.toDataURL('image/png');

            // Create a temporary link element to trigger the download
            const downloadLink = document.createElement('a');
            downloadLink.href = imageData;
            downloadLink.download = `${filename}.png`;
            downloadLink.click();

            // Hide the custom alert after saving
            document.getElementById('customAlert').style.display = 'none';
            showGeneralAlert("Image saved successfully!", "Success");
        });

        // Handle Cancel Button inside Custom Alert
        document.getElementById('cancelAlertSave').addEventListener('click', function() {
            document.getElementById('customAlert').style.display = 'none';
        });

        // Handle Reset Button
        document.getElementById('resetCanvas').addEventListener('click', function() {
            canvas.clear();
            canvas.setBackgroundColor(document.getElementById('bgColor').value, canvas.renderAll.bind(canvas));
            showGeneralAlert("Canvas has been reset.", "Info");
        });

        // Handle Delete Selected Image
        document.getElementById('deleteImage').addEventListener('click', function() {
            let activeObj = canvas.getActiveObject();
            if (activeObj) {
                canvas.remove(activeObj);
                canvas.renderAll();
                showGeneralAlert("Image deleted successfully.", "Success");
            } else {
                showGeneralAlert("Please select an image to delete.", "Error");
            }
        });

        // Show General Alert
        function showGeneralAlert(message, title) {
            document.getElementById('alertTitle').innerText = title;
            document.getElementById('alertMessage').innerText = message;
            document.getElementById('generalAlert').style.display = 'flex';
        }

        // Confirm General Alert Action
        document.getElementById('confirmGeneralAlert').addEventListener('click', function() {
            document.getElementById('generalAlert').style.display = 'none';
        });

        // Close alert when clicking outside of it
        window.onclick = function(event) {
            const customAlert = document.getElementById('customAlert');
            const generalAlert = document.getElementById('generalAlert');
            if (event.target === customAlert) {
                customAlert.style.display = 'none';
            } else if (event.target === generalAlert) {
                generalAlert.style.display = 'none';
            }
        };
    });
</script>

<style>
    .custom-alert {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    }

    .custom-alert-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
    }
</style>
@endsection
