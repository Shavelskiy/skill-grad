import React, { useState, useEffect } from 'react'
import { CATEGORY_INDEX, CATEGORY_VIEW, CATEGORY_CREATE } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_CATEGORY_URL } from '../../utils/api/endpoints'
import { Link } from 'react-router-dom'


const CategoryView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0,
    slug: '',
    parentCategory: null,
    childCategories: [],
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список категорий',
        link: CATEGORY_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр категории "${item.name}"`))
  }, [item])

  useEffect(() => {
    setItem({...item, id: match.params.id})
  }, [match.params.id])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      name: data.name,
      slug: data.slug,
      sort: data.sort,
      parentCategory: data.parent_category,
      childCategories: data.child_categories,
    })
  }

  const getLinkToParent = () => {
    return <Link to={CATEGORY_VIEW.replace(':id', item.parentCategory.id)}>{item.parentCategory.name}</Link>
  }

  const renderChildItemsList = () => {
    if (item.childCategories.length < 1) {
      return <></>
    }

    const items = item.childCategories.map((item, key) => {
      return (
        <tr key={key}>
          <td>{item.id}</td>
          <td><Link to={CATEGORY_VIEW.replace(':id', item.id)}>{item.name}</Link></td>
          <td>{item.sort}</td>
        </tr>
      )
    })

    return (
      <Portlet
        width={50}
        title={'Спискок вложенных категорий'}
        titleIcon={'list'}
        withButton={false}
      >
        <table>
          <thead>
          <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Сортировка</td>
          </tr>
          </thead>
          <tbody>{items}</tbody>
        </table>
      </Portlet>
    )
  }
console.log(item)
  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_CATEGORY_URL.replace(':id', item.id)}
      setItem={setItemFromResponse}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'eye'}
        withButton={item.parentCategory === null}
        buttonText={'Добавить вложенную категорию'}
        buttonLink={CATEGORY_CREATE.replace(':id', item.id)}
      >
        <table>
          <tbody>
          <tr>
            <td>ID</td>
            <td>{item.id}</td>
          </tr>
          <tr>
            <td>Название</td>
            <td>{item.name}</td>
          </tr>
          <tr>
            <td>Символьный код</td>
            <td>{item.slug}</td>
          </tr>
          <tr>
            <td>Сортировка</td>
            <td>{item.sort}</td>
          </tr>
          <tr>
            <td>Родительская категория</td>
            <td>{(item.parentCategory !== null) ? getLinkToParent() : '-'}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
      {renderChildItemsList()}
    </ViewPageTemplate>
  )
}

export default CategoryView
