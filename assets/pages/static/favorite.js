import {addProviderToFavorite, addProgramToFavorite, addArticleToFavorite} from '@/components/common/favorite'
import {insertParam} from '@/helpers/location-helper'

const tabProviders = document.querySelector('.tab-providers')
const tabPrograms = document.querySelector('.tab-programs')
const tabArticles = document.querySelector('.tab-articles')

const navProviders = document.querySelector('.nav-item-providers')
const navPrograms = document.querySelector('.nav-item-programs')
const navArticles = document.querySelector('.nav-item-articles')


const initNavClick = (nav) => {
  nav.onclick = () => {
    if (nav.classList.contains('active')) {
      return
    }

    switch (nav) {
      case navProviders:
        insertParam('tab', 'providers')
        navPrograms.classList.remove('active')
        navArticles.classList.remove('active')

        tabPrograms.classList.remove('active')
        tabArticles.classList.remove('active')

        tabProviders.classList.add('active')
        break
      case navPrograms:
        insertParam('tab', 'programs')
        navProviders.classList.remove('active')
        navArticles.classList.remove('active')

        tabProviders.classList.remove('active')
        tabArticles.classList.remove('active')

        tabPrograms.classList.add('active')
        break
      case navArticles:
        insertParam('tab', 'articles')
        navProviders.classList.remove('active')
        navPrograms.classList.remove('active')

        tabProviders.classList.remove('active')
        tabPrograms.classList.remove('active')

        tabArticles.classList.add('active')
        break
    }

    nav.classList.add('active')
  }
}

initNavClick(navProviders)
initNavClick(navPrograms)
initNavClick(navArticles)

document.querySelectorAll('.add-provider-favorites').forEach(item => {
  item.onclick = () => addProviderToFavorite(item)
})

document.querySelectorAll('.add-program-favorites').forEach(item => {
  item.onclick = () => addProgramToFavorite(item)
})

document.querySelectorAll('.add-article-favorites').forEach(item => {
  item.onclick = () => addArticleToFavorite(item)
})