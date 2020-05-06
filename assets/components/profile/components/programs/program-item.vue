<template lang="pug">
  .item
    .name.text {{ program.name }}
    .categories.text 
      a(href="#" v-for="category in program.categories" :key="category.id") {{ category }}
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip {{ program.requests.new }}
      br
      span.mail-total Всего: {{ program.requests.total }}
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip {{ program.questions.new }}
      br
      span.mail-total Всего: {{ program.questions.total }}
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip {{ program.answers.new }}
      br
      span.mail-total Всего: {{ program.answers.total }}
    .logo
      img(src="./../../images/goal.svg")
    .logo
      img(src="./../../images/copy.svg")
    .logo
      img(src="./../../images/edit.svg")
    .logo
      img(src="./../../images/close.svg")
</template>

<script>
  export default {
    name: 'program-item',
    props: ['program'],
  }
</script>
