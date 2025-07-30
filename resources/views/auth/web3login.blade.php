@extends('layouts.app')

@section('title', 'Login with MetaMask')

@section('content')
<div class="container mt-5 text-center">
    <h2>🔐 Login with MetaMask</h2>
    <button class="btn btn-primary" onclick="connectWallet()">Connect MetaMask</button>
    <form id="logoutForm" action="{{ route('web3.logout') }}" method="POST" style="display: none;">@csrf</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script>
let web3;
async function connectWallet() {
    if (typeof window.ethereum !== 'undefined') {
        web3 = new Web3(window.ethereum);
        try {
            const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
            const address = accounts[0];
            const message = "Login to your account with MetaMask - " + new Date().getTime();

            const signature = await web3.eth.personal.sign(message, address, '');

            fetch("{{ route('web3.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    address: address,
                    message: message,
                    signature: signature
                })
            }).then(res => res.json()).then(data => {
                if (data.address) {
                    alert("✅ Logged in as " + data.address);
                    location.reload();
                } else {
                    alert("❌ Login failed.");
                }
            });
        } catch (err) {
            console.error(err);
            alert("❌ MetaMask login canceled or failed.");
        }
    } else {
        alert("MetaMask not installed!");
    }
}
</script>
@endsection
