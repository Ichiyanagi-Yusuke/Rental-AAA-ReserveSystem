// ローディング画面の処理
window.addEventListener('load', function () {
    const loadingScreen = document.getElementById('loadingScreen');

    // 最小表示時間を設けてスムーズな体験を提供
    setTimeout(function () {
        if (loadingScreen) {
            loadingScreen.classList.add('loaded');
        }
    }, 1000);
});

// スムーズスクロール
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            // メニューが開いている場合は閉じる
            closeSideMenu();

            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ハンバーガーメニュー
const hamburger = document.getElementById('hamburger');
const sideMenu = document.getElementById('sideMenu');
const overlay = document.getElementById('overlay');
const closeMenuBtn = document.getElementById('closeMenu');

// メニューを開く
function openSideMenu() {
    hamburger.classList.add('active');
    sideMenu.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// メニューを閉じる
function closeSideMenu() {
    hamburger.classList.remove('active');
    sideMenu.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// ハンバーガーボタンクリック
hamburger.addEventListener('click', () => {
    if (sideMenu.classList.contains('active')) {
        closeSideMenu();
    } else {
        openSideMenu();
    }
});

// 閉じるボタンクリック
closeMenuBtn.addEventListener('click', closeSideMenu);

// オーバーレイクリック
overlay.addEventListener('click', closeSideMenu);

// サイドメニューのリンククリック
document.querySelectorAll('.side-menu-link').forEach(link => {
    link.addEventListener('click', () => {
        closeSideMenu();
    });
});

// ESCキーでメニューを閉じる
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sideMenu.classList.contains('active')) {
        closeSideMenu();
    }
});

// スクロール時のナビゲーションバーの背景変更
const navbar = document.querySelector('.navbar');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        navbar.style.background = 'rgba(255, 255, 255, 1)';
        navbar.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.15)';
    } else {
        navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
    }

    lastScroll = currentScroll;
});

// スクロールアニメーション
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// アニメーション対象の要素を監視
const animateElements = document.querySelectorAll(
    '.feature-item, .pricing-card, .news-card, .access-info, .access-map'
);
animateElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// 料金カードのボタン
document.querySelectorAll('.btn-pricing').forEach(button => {
    button.addEventListener('click', function () {
        const cardTitle = this.closest('.pricing-card').querySelector('h3').textContent;
        alert(`${cardTitle}の詳細ページへ遷移します。`);
    });
});

// 予約ボタン
// document.querySelectorAll('.btn-reservation, .btn-reservation-header').forEach(button => {
//     button.addEventListener('click', function(e) {
//         e.preventDefault();
//         alert('予約ページへ遷移します。\n\n実際のサイトでは予約フォームが表示されます。');
//     });
// });

// ニュースカードのクリック
document.querySelectorAll('.news-card').forEach(card => {
    card.addEventListener('click', function () {
        const newsTitle = this.querySelector('h3').textContent;
        console.log(`「${newsTitle}」がクリックされました`);

        // 簡単なインタラクション効果
        this.style.transform = 'scale(0.98)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    });
});

// ページロード時のアニメーション
window.addEventListener('load', () => {
    // ヒーローセクションのフェードイン
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.style.opacity = '0';
        setTimeout(() => {
            heroContent.style.transition = 'opacity 1s ease';
            heroContent.style.opacity = '1';
        }, 300);
    }
});

// 画面サイズ変更時の対応
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // 画面サイズが変わったときにメニューが開いていたら閉じる
        if (window.innerWidth > 768 && sideMenu.classList.contains('active')) {
            closeSideMenu();
        }
    }, 250);
});

// ヒーローセクションの高さ調整
function adjustHeroHeight() {
    const hero = document.querySelector('.hero');
    if (hero) {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
}

adjustHeroHeight();
window.addEventListener('resize', adjustHeroHeight);

console.log('⛷️ RENTAL AAA - ウェブサイトが読み込まれました！');
