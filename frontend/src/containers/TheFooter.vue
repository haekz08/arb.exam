<template>
  <CFooter :fixed="false">
    <div>
      <a href="#" target="_blank">Demo</a>
      <span class="ml-1">&copy; {{new Date().getFullYear()}}</span>
    </div>
    <div class="ml-auto">
      <span class="mr-1">Demo</span>
    </div>
  </CFooter>
</template>

<script>
export default {
  name: 'TheFooter'
}
</script>
