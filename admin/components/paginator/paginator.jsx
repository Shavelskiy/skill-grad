import React from 'react'

import { Item, EmptyItem, Arrow } from './items'

import css from './paginator.scss?module'


const Paginator = ({currentPage, totalPages, click}) => {
  const renderItem = (page) => {
    return (
      <Item
        key={page}
        page={page}
        active={page === currentPage}
        click={() => click(page)}
      />
    )
  }

  const getOffset = () => {
    let result = {
      start: 0,
      end: 0,
    }

    if (currentPage < 5 || currentPage > (totalPages - 4)) {
      if (currentPage === 3) {
        result.start = 4
      } else if (currentPage === 4) {
        result.start = 5
      } else {
        result.start = 3
      }

      if (currentPage === (totalPages - 2)) {
        result.end = 3
      } else if (currentPage === (totalPages - 3)) {
        result.end = 4
      } else {
        result.end = 2
      }
    } else {
      result.start = 2
      result.end = 1
    }

    return result
  }

  if (totalPages <= 1) {
    return <></>
  }

  let items = []

  items.push(
    <Arrow
      key={0}
      left={true}
      active={(currentPage !== 1)}
      click={() => click(currentPage - 1)}
    />
  )

  if (totalPages > 7) {
    const offset = getOffset()
    for (let i = 1; i <= offset.start; i++) {
      items.push(renderItem(i))
    }

    items.push(<EmptyItem key={0.5}/>)

    if (currentPage >= 5 && currentPage <= (totalPages - 4)) {
      for (let i = currentPage - 1; i <= currentPage + 1; i++) {
        items.push(renderItem(i))
      }

      items.push(<EmptyItem key={1.5}/>)
    }

    for (let i = totalPages - offset.end; i <= totalPages; i++) {
      items.push(renderItem(i))
    }
  } else {
    for (let i = 1; i <= totalPages; i++) {
      items.push(renderItem(i))
    }
  }

  items.push(
    <Arrow
      key={totalPages + 1}
      left={false}
      active={currentPage < totalPages}
      click={() => click(currentPage + 1)}
    />
  )

  return (
    <ul className={css.pagination}>
      {items}
    </ul>
  )
}

export default Paginator
