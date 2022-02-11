<script>

document.addEventListener('DOMContentLoaded', () => {
      window.livewire.on('scan-ok', msg => {
          alert(msg)
      })
      window.livewire.on('scan-notfound', msg => {
          alert(msg)
      })
      window.livewire.on('no-stock', msg => {
          alert(msg)
      })
      window.livewire.on('sale-error', msg => {
          alert(msg)
      })
      window.livewire.on('print-ticket', msg => {
          alert(msg)
      })
    })
</script>