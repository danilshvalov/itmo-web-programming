#include "website_viewer.hpp"

#include <QLayout>

WebsiteViewer::WebsiteViewer(QWidget* parent) : QMainWindow(parent) {
    setWindowTitle("Демонстрация веб-сайтов");

    timer_ = new QTimer(this);
    connect(timer_, &QTimer::timeout, this, &WebsiteViewer::onTimerTimeout);

    url_label_ = new QLabel(this);
    QFont font = url_label_->font();
    font.setPixelSize(18);
    url_label_->setFont(font);
    url_label_->setAlignment(Qt::AlignCenter);
    url_label_->setFixedHeight(30);

    web_view_ = new QWebEngineView(this);

    QVBoxLayout* layout = new QVBoxLayout();
    layout->addWidget(url_label_);
    layout->addWidget(web_view_);

    QWidget* window = new QWidget();
    window->setLayout(layout);
    setCentralWidget(window);
}

void WebsiteViewer::onTimerTimeout() { showNextWebsite(); }

void WebsiteViewer::setWebsiteInfo(QList<WebsiteDisplayInfo> website_info) {
    website_info_ = std::move(website_info);
    current_website = 0;
}

void WebsiteViewer::showEvent(QShowEvent* event) {
    web_view_->show();
    showNextWebsite();
    QMainWindow::showEvent(event);
}

void WebsiteViewer::showNextWebsite() {
    if (current_time > 0) {
        const WebsiteDisplayInfo& info = website_info_[current_website - 1];
        url_label_->setText(QString("URL: %1 Осталось: %2")
                                .arg(info.url.toString())
                                .arg(current_time / 1000));
        current_time -= 1000;
    } else if (current_website < website_info_.size()) {
        const WebsiteDisplayInfo& info = website_info_[current_website];
        current_time = info.show_time;
        web_view_->load(info.url);
        ++current_website;
    } else {
        web_view_->close();
        close();
    }

    if (current_time > 0) {
        timer_->start(1000);
    }
}
