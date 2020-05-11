<template lang="pug">
  router-link(:to="{ name: route}" v-slot="{ href, navigate, isActive }")
    div(:class="`profile-menu-item ${(isActive) ? 'active' : ''}`")
      a(:href="href" @click="navigate") {{ text }}
</template>

<script>
  export default {
    name: 'menuItem',
    props: ['route', 'text'],
  }
</script>
