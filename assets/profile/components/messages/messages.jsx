import React, { useEffect } from 'react'

const Messages = () => {
  return (
    <>
      <div className="container-0 mt-40 non-margin-mobile">
        <div className="messages">
          <div className="messages-sidebar active">
            <div className="search">
              <div className="input-search-gray">
                <input type="text" placeholder="Поиск собеседника"/>
                <i className="icon-search"></i>
              </div>
            </div>
            <div className="users">
              <div className="user new-message">
                <div className="avatar">
                  <a href="#"><img className="rounded" src="../../img/photo.jpg" alt=""/></a>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                    <span className="notification">10</span>
                  </div>
                </div>
              </div>
              <div className="user new-message">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                    <span className="notification">10</span>
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">22 авг 2020</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент п...
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="messages-content">
            <div className="header-content">
              <i id="back" className="icon-left"></i>
              <div className="avatar">
                <a href="#"><img className="rounded" src="../../img/photo.jpg" alt=""/></a>
              </div>
              <div className="info">
                Автор беседы: <a href="#">Викторов Тимофей</a>
              </div>
            </div>
            <div className="messages-box">
              <div className="line-date">
                22 августа 2020
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">
												<span className="day">22 авг 2020, </span>
												<span className="time">12:35</span>
											</span>
                  </div>
                  <div className="last-message">
                    Хотел уточнить один момент по поводу процесса обучения. Есть ли возможность обучаться удаленно,
                    в скайпе например? У меня нет возможности посещать учебное заведение.
                  </div>
                </div>
              </div>
              <div className="user my">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Ермакова Валентина
                    </a>
                    <span className="date">
												<span className="day">22 авг 2020, </span>
												<span className="time">12:35</span>
											</span>
                  </div>
                  <div className="last-message">
                    Да, такой вид обучения возможен. Занятия проводятся индивидуально, график обучения обговариваете
                    совместно с преподавателем.
                  </div>
                </div>
              </div>
              <div className="user">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Викторов Тимофей</a>
                    <span className="date">
												<span className="day">22 авг 2020, </span>
												<span className="time">12:35</span>
											</span>
                  </div>
                  <div className="last-message">
                    И оплата в рассрочку тоже возможна?
                  </div>
                </div>
              </div>
              <div className="user my">
                <div className="avatar">
                  <img className="rounded" src="../../img/photo.jpg" alt=""/>
                </div>
                <div className="information w-100">
                  <div className="d-flex j-c-space-between">
                    <a className="name" href="#">Ермакова Валентина
                    </a>
                    <span className="date">
												<span className="day">22 авг 2020, </span>
												<span className="time">12:35</span>
											</span>
                  </div>
                  <div className="last-message">
                    Да, конечно
                  </div>
                </div>
              </div>
            </div>
            <div className="textarea-box">
              <textarea rows="10" className="textarea" placeholder="Текст сообщения"></textarea>
              <a>
                <span className="icon send-message"></span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </>
  )
}

export default Messages
