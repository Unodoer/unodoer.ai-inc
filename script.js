document.getElementById('chat-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  const input = document.getElementById('user-input');
  const message = input.value.trim();
  if (!message) return;
  appendMessage('user', message);
  input.value = '';
  appendMessage('bot', '...');
  const response = await fetch('bot.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({message: message})
  });
  const data = await response.json();
  document.querySelector('#chat-box .bot:last-child').textContent = data.reply;
});

function appendMessage(sender, text) {
  const msg = document.createElement('div');
  msg.className = 'message ' + sender;
  msg.textContent = text;
  document.getElementById('chat-box').appendChild(msg);
  document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
}