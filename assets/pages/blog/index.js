import './index.scss'


const articlesNav = document.querySelector('.articles-nav')

if (articlesNav) {
  const allArticlesNav = articlesNav.querySelector('.all-articles')
  const selfArticlesNav = articlesNav.querySelector('.self-articles')
  const moderationArticlesNav = articlesNav.querySelector('.moderation-articles')

  const allArticlesContent = document.querySelector('.all-articles-tab')
  const selfArticlesContent = document.querySelector('.self-articles-tab')
  const moderationArticlesContent = document.querySelector('.moderation-articles-tab')

  const initNavClick = (nav) => {
    nav.onclick = () => {
      if (nav.classList.contains('active')) {
        return
      }

      switch (nav) {
        case allArticlesNav:
          selfArticlesNav.classList.remove('active')
          moderationArticlesNav.classList.remove('active')

          selfArticlesContent.classList.remove('active')
          moderationArticlesContent.classList.remove('active')

          allArticlesContent.classList.add('active')
          break
        case selfArticlesNav:
          allArticlesNav.classList.remove('active')
          moderationArticlesNav.classList.remove('active')

          allArticlesContent.classList.remove('active')
          moderationArticlesContent.classList.remove('active')

          selfArticlesContent.classList.add('active')
          break
        case moderationArticlesNav:
          allArticlesNav.classList.remove('active')
          selfArticlesNav.classList.remove('active')

          allArticlesContent.classList.remove('active')
          selfArticlesContent.classList.remove('active')

          moderationArticlesContent.classList.add('active')
          break
      }

      nav.classList.add('active')
    }
  }

  initNavClick(allArticlesNav)
  initNavClick(selfArticlesNav)
  initNavClick(moderationArticlesNav)
}
