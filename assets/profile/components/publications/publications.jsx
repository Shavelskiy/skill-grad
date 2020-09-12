import React from 'react'

const Publications = () => {
  return (
    <>
      <div className="main_profile">
        <div className="container-0 mt-20">
          <div className="alert w-100 mb-20">
            Бесплатно разместите новость или статью о вашей организации или программе
            <button className="open-add-publication button-blue">Разместить статью</button>
          </div>


          <div className="card-blog">
            <div className="card-container">
              <div className="card-img">
                <img src="/img/card-image.jpg" alt=""/>
                  <div className="bottom">
                    <div className="views">
                      <span className="icon view"></span>
                      253
                    </div>
                    <div className="comments">
                      <span className="icon comment"></span>
                      <a href="#">25 комментариев</a>
                    </div>
                  </div>
              </div>
              <div className="card-content">
                <div className="top">
                  <div className="date">
                    <span className="icon calendar"></span>
                    19.02.2019
                  </div>
                  <div className="time-read">
                    <span className="icon read"></span>
                    <span className="text">Время чтения:</span> 2 минуты
                  </div>
                </div>
                <h4 className="title">Семейное образование: с чего начинать родителям обучение ребенка «дома»</h4>
                <p className="description">
                  Для того чтобы составить инструкцию для родителей, решивших перевести ребенка на семейное обучение и
                  не знающих с чего начать, «Учеба.ру» поговорила с ведущим эксперт...
                  <a href="/">Читать далее</a>
                </p>
                <div className="mobile-bottom">
                  <div className="views">
                    <span className="icon view"></span>
                    253
                  </div>
                  <div className="comments">
                    <span className="icon comment not"></span>
                    <a href="#">Нет комментариев</a>
                  </div>
                </div>
                <div className="bottom">
                  <div className="status-block">
                    <span className="icon status no"></span>
                    Опубликована
                  </div>
                  <div className="rating">
                    <div className="minus-block">
                      <span className="icon minus"></span>
                      5
                    </div>
                    <div className="plus-block">
                      <span className="icon plus"></span>
                      26
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
        <div className="pagination mt-20">
          <a href="#">
            <span className="prev"></span>
          </a>
          <a href="#">1</a>
          <a className="active" href="#">2</a>
          <a href="#">3</a>
          <a href="#">4</a>
          <a href="#">5</a>
          <a href="#">6</a>
          <a href="#">
            <span className="next"></span>
          </a>
        </div>
      </div>
      <div id="add-publication" className="modal">
        <div className="modal-content">
          <span className="close">&times;</span>
          <div className="content">
            <h4>Добавить статью</h4>
            <div className="modal-publication">
              <form action="">
                <div className="container-0">
                  <div className="col-lg-12">
                    <input className="input" type="text" placeholder="Название статьи"/>
                  </div>

                  <div className="container-0 al-i-c">
                    <div className="col-lg-6 col-sm-4">
                      <label className="block-upload" htmlFor="upload-photo">
                        <img src="/img/interface.png" alt=""/>
                        <span className="link">Загрузить изображение</span>
                      </label>
                      <input type="file" name="photo" id="upload-photo"/>
                    </div>
                    <div className="col-lg-6 col-sm-4">
                      <div className="select custom-select-wrapper">
                        <div className="custom-select">
                          <div className="custom-select__trigger"><span>Выбрать категорию</span>
                            <div className="arrow"></div>
                          </div>
                          <div className="custom-options scrollbar">
                            <span className="custom-option category-option selected" data-value="tesla">Tesla</span>
                            <span className="custom-option category-option" data-value="volvo">Volvo</span>
                            <span className="custom-option category-option" data-value="mercedes">Mercedes</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="col-lg-12">
                    <textarea className="textarea" rows="5" placeholder="Вступительный текст"></textarea>
                  </div>
                  <div className="col-lg-12">
                    <div className="container-text">
                      <div id="toolbar"></div>
                      <div className="textarea editor" id="editor"></div>
                    </div>
                  </div>
                  <div className="container-0 justify-content-end mt-20">
                    <div className="col-lg-4 col-sm-4 mb-20">
                      <button className="button-red">Отменить</button>
                    </div>
                    <div className="col-lg-6 col-sm-4">
                      <button type="button" className="open-callback button-blue">Опубликовать</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div id="callback" className="modal callback">
        <div className="modal-content">
          <span className="close">&times;</span>
          <div className="content">
            <p className="text-bold">
              Ваша статья направлена модератору.
            </p>
            <p className="text-bold">
              После модерации она будет опубликована.
            </p>
          </div>
        </div>
      </div>

    </>
  )
}

export default Publications
