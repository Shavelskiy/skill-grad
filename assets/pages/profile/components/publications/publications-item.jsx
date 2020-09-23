import React from 'react'

import {declension} from '@/helpers/declension'
import {dateFormat} from '@/helpers/date-formater'

import css from './scss/publications-item.scss?module'
import cn from 'classnames'


const PublicationsItem = ({item}) => {
  console.log(item)
  return (
    <div className={css.cardBlog}>
      <div className={css.cardContainer}>
        <div className={css.cardImg}>
          <img src="/img/card-image.jpg" alt=""/>
          <div className={css.bottom}>
            <div className={css.views}>
              <span className="icon view"></span>
              {item.views}
            </div>
            <div className={css.comments}>
              <span className={cn('icon', 'comment')}></span>
              <a href={item.link} target={'_blank'}>{item.comments} комментариев</a>
            </div>
          </div>
        </div>
        <div className={css.cardContent}>
          <div className={css.top}>
            <div className={css.date}>
              <span className={cn('icon', 'calendar')}></span>
              {dateFormat(new Date(item.date))}
            </div>
            <div className={css.timeRead}>
              <span className={cn('icon', 'read')}></span>
              <span className="text">Время чтения:&nbsp;</span>
              {item.reading_time} {declension(item.reading_time, ['минута', 'минуты', 'минут'])}
            </div>
          </div>
          <h4 className={css.title}>{item.name}</h4>
          <p className={css.description}>
            {item.preview}&nbsp;
            <a href={item.link} target={'_blank'}>Читать далее</a>
          </p>
          <div className={css.mobileBottom}>
            <div className={css.mobileBottom}>
              <span className={cn('icon', 'view')}></span>
              {item.views}
            </div>
            <div className={css.comments}>
              <span className={cn('icon', 'comment')}></span>
              <a href={item.link} target={'_blank'}>{item.comments} комментариев</a>
            </div>
          </div>
          <div className={css.bottom}>
            <div className={css.statusBlock}>
              <span className={cn('icon', 'status', {'not': !item.active})}></span>
              {item.active ? 'Опубликована' : 'На модерации'}
            </div>
            <div className={css.rating}>
              <div className={css.minusBlock}>
                <span className={cn('icon', 'minus')}></span>
                {item.reviews.likes}
              </div>
              <div className={css.plusBlock}>
                <span className={cn('icon', 'plus')}></span>
                {item.reviews.dislikes}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

export default PublicationsItem
