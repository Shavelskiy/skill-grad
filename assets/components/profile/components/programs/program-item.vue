<template lang="pug">
  .item
    .name.text Маркетинг (многопрофильный бакалавариат "Маркетинг и управление продажами")
    .categories.text 
      a(href="#") Маркетинг
      a(href="#") Оффиское дело
      a(href="#") Управление и бизнес
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip 23
      br
      span.mail-total Всего: 234
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip 23
      br
      span.mail-total Всего: 234
    .mail.logo
      img.mail-logo(src="./../../images/mail.svg")
      .mail-tooltip 23
      br
      span.mail-total Всего: 234
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
  }
</script>
