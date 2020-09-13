import React from 'react'

import dateFormat from '../../helpers/date-fromater'


const Item = ({program, openReviewModal}) => {
  return (
    <>
      <tr>
        <td>
          <a className="title-link" href={program.link} target="_blank">
            {program.name}
          </a>
        </td>
        <td>{program.categories}</td>
        <td>
          <a href={program.provider.link} target="_blank">{program.provider.name}</a>
        </td>
        <td><span className="date">{ dateFormat(new Date(program.date)) }</span></td>
        <td>
          <button className="open-learn button" onClick={openReviewModal}>Оставить оценку</button>
        </td>
        {/*<td>*/}
        {/*  <div className="success-block">*/}
        {/*    <div className="success">*/}
        {/*      <span>Оценка поставлена</span>*/}
        {/*      <i className="icon-correct"></i>*/}
        {/*    </div>*/}
        {/*    <a className="open-learn">посмотреть</a>*/}
        {/*  </div>*/}
        {/*</td>*/}
      </tr>
    </>
  )
}

export default Item
