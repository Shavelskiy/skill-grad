// import axios from 'axios'
//
// axios.get('/chat/start')
//   .then(response => {
//
//     const socket = new WebSocket('ws://localhost:8081')
//     const token = response.data.token
//
//     socket.onopen = () => {
//       socket.send(JSON.stringify({
//         type: 'init',
//         token: token
//       }));
//     };
//
//     socket.onmessage = (e) => {
//       const data = JSON.parse(e.data)
//       // console.log(data)
//       // switch (data.type) {
//       //   case 'focusIn':
//       //     const userFromInId = Number(data.from);
//       //     if (!this.typingUserIds.includes(userFromInId)) {
//       //       this.typingUserIds.push(userFromInId);
//       //     }
//       //     break;
//       //   case 'focusOut':
//       //     const userFromOutId = Number(data.from);
//       //     this.typingUserIds = this.typingUserIds.filter((item) => {
//       //       return item !== userFromOutId;
//       //     });
//       //     break;
//       //   case 'sendMessage':
//       //     if (this.allMessages[data.withId] === undefined) {
//       //       this.allMessages[data.withId] = [];
//       //     }
//       //     this.allMessages[data.withId].push(data.message);
//       //     this.messagesKey++;
//       //     break;
//       // }
//     };
//   })
//   .catch(error => {
//     console.log(error);
//   });
