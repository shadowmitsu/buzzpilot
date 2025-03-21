@extends('layouts.app')
@section('title', 'Chai AI')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Chai AI</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <div class="row justify-content-between g-3">
                        <div class="col-lg-6">
                            <h4 class="title">Chai AI</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="promptInput" class="form-label">Masukkan Perintah atau Prompt:</label>
                        <input type="text" id="promptInput" class="form-control"
                            placeholder="Tulis perintah AI disini..." />
                    </div>
                    <button id="generateAi" class="btn btn-primary">Generate AI Response</button>
                    <hr />
                    <p id="aiResponse" class="text-muted"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generateAi').addEventListener('click', function() {
            const promptInput = document.getElementById('promptInput').value;
    
            if (promptInput.trim() === '') {
                alert('Harap masukkan teks untuk dikirim ke AI.');
                return;
            }
    
            // Reset previous response
            document.getElementById('aiResponse').innerHTML = '';
    
            // API call to RapidAPI
            fetch('https://chatgpt-42.p.rapidapi.com/conversationgpt4', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'x-rapidapi-host': 'chatgpt-42.p.rapidapi.com',
                    'x-rapidapi-key': '15e9f901cfmsh99f13d1552365aap1a2e98jsn05da2723d2df'
                },
                body: JSON.stringify({
                    messages: [{ role: 'user', content: promptInput }],
                    system_prompt: '',
                    temperature: 0.9,
                    top_k: 5,
                    top_p: 0.9,
                    max_tokens: 100000,
                    web_access: false
                })
            })
            .then(response => response.json())
            .then(data => {
                const responseText = data.result;
                typeWriter(responseText, 0);
            })
            .catch(error => console.error('Error:', error));
    
            // Function to simulate typing effect
            function typeWriter(text, i) {
                const speed = 30;  // Mempercepat efek pengetikan
    
                if (i < text.length) {
                    const currentChar = text.charAt(i);
    
                    if (currentChar === '\n') {
                        document.getElementById('aiResponse').innerHTML += '<br>';  // Tangani newline
                    } else {
                        document.getElementById('aiResponse').innerHTML += currentChar;
                    }
    
                    // Ensure emoji and special characters render correctly
                    setTimeout(() => typeWriter(text, i + 1), speed);
                }
            }
        });
    </script>
    
@endsection
