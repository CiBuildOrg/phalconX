package com.bida365;

import android.app.Application;
import android.util.Log;

import com.facebook.react.ReactApplication;
import com.facebook.react.ReactInstanceManager;
import com.facebook.react.ReactNativeHost;
import com.facebook.react.ReactPackage;
import com.facebook.react.shell.MainReactPackage;
import com.facebook.soloader.SoLoader;

import java.util.Arrays;
import java.util.List;

// OneSignal push notification
import com.geektime.reactnativeonesignal.ReactNativeOneSignalPackage;

// Adnroid status bar
import me.neo.react.StatusBarPackage;

// Photo View
import com.reactnative.photoview.PhotoViewPackage;

// Video
import com.brentvatne.react.ReactVideoPackage;

import com.sbugert.rnadmob.RNAdMobPackage;

public class MainApplication extends Application implements ReactApplication {

  private final ReactNativeHost mReactNativeHost = new ReactNativeHost(this) {
    @Override
    protected boolean getUseDeveloperSupport() {
      return BuildConfig.DEBUG;
    }

    @Override
    protected List<ReactPackage> getPackages() {
      return Arrays.<ReactPackage>asList(
          new MainReactPackage(),
          new StatusBarPackage(),
          new PhotoViewPackage(),
          new ReactVideoPackage(),
          new ReactNativeOneSignalPackage(),
          new RNAdMobPackage()
      );
    }
  };

  @Override
  public ReactNativeHost getReactNativeHost() {
    return mReactNativeHost;
  }
}
