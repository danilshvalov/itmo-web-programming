#pragma once

#include "website_display_info.hpp"

#include <QLabel>
#include <QMainWindow>
#include <QTimer>
#include <QWebEngineView>

class WebsiteViewer : public QMainWindow {
    Q_OBJECT

   public:
    WebsiteViewer(QWidget* parent = nullptr);

    void setWebsiteInfo(QList<WebsiteDisplayInfo> website_info);

   protected:
    void showEvent(QShowEvent* event) override;

   private:
    void onTimerTimeout();

    void showNextWebsite();

    QLabel* url_label_;
    QWebEngineView* web_view_;
    QList<WebsiteDisplayInfo> website_info_;
    QTimer* timer_;
    int current_website;
    int current_time;
};
